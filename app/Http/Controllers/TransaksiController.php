<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Barang;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;
use Auth;
use DB;
use App\DetailTransaksi;
use Mpdf\Mpdf;
use AppHelper;

class TransaksiController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Transaksi',
        'route' => 'admin.transaksi',
        'menu' => 'transaksi',
        'icon' => 'fa fa-group',
        'theme' => 'skin-blue',
        'config' => [
            'index.delete.is_show' => false
        ]
    ];

    public function form()
    {
       
        $type = [
            [
                'value' => 'Penjualan',
                'name' => 'Penjualan'
            ],
            [
                'value' => 'Pembelian',
                'name' => 'Pembelian'
            ],
        ];
        return [
            [
                'label' => 'Tanggal Transaksi',
                'name' => 'tanggal',
                'type' => 'text',
                'attr' => 'readonly',
                'value' => date('Y-m-d'),
                'view_index' => true,
            ],   
            [
                'label' => 'Jenis',
                'name' => 'type',
                'type' => 'hidden',
                'view_index' => true,
            ],   
            [
                'label' => 'Tipe',
                'name' => 'type',
                'type' => 'select',
                'option' => $type,
                'view_index' => true,
            ],
            
            [
                'label' => 'Total',
                'name' => 'total',
                'type' => 'hidden',
                'format' => 'rupiah',
                'view_index' => true,
            ],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $template = (object) $this->template;
        $form = $this->form();

        $dari_tgl = empty($request->dari_tgl) ? date('Y-m-01') : $request->dari_tgl;
        $sampai_tgl = empty($request->sampai_tgl) ? date('Y-m-t') : $request->sampai_tgl;
        $type = $request->type;
        
        $data = Transaksi::whereBetween('tanggal',[$dari_tgl,$sampai_tgl]);
        if($type == ''){
            $data = $data->get();
        }else{
            $data = $data->where('type',$type)->get();
        }

        return view('admin.transaksi.index',compact('template','form','data','dari_tgl','sampai_tgl','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::all();
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.transaksi.create',compact('template','form','barang'));
    }


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        
        DB::beginTransaction();
            $return = true;
            $transaksi = Transaksi::create([
                'tanggal' => date('Y-m-d H:i:s'),
                'user_id' => Auth::user()->id,
                'type' => $request->type,
                'status' => 'Aktif',
                'total' => $request->total
            ]);

            foreach($request->barang_id as $key => $value){
                $array['barang_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $transaksi->id;

                $barang = Barang::find($value);
                if($request->type == 'Penjualan'){
                    $stok = $barang->jumlah - $request->jumlah[$key];
                    if($stok < 0){
                        Alert::make('danger',"Jumlah stok $barang->nama tidak mencukupi");
                        $return = false;
                    }
                }else{
                    $stok = $barang->jumlah + $request->jumlah[$key];
                }
                $barang->update(['jumlah' => $stok]);
                DetailTransaksi::create($array);
                
            }

            
        

        if($return){
            DB::commit();
            Alert::make('success','Berhasil simpan data');
            return redirect(route($this->template['route'].'.index'));
        }else{
            DB::rollback();
            return redirect(route($this->template['route'].'.create'));

        }
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Transaksi::find($id);
        if($data->type == 'Penjualan'){
            $detail = DetailTransaksi::where('transaksi_id',$id)->get();
            $template = (object) $this->template;
            $form = $this->form();
            return view('admin.transaksi.show',compact('data','template','form','detail'));

        }else{
            $detail = DetailTransaksiBeli::where('transaksi_id',$id)->get();
            $template = (object) $this->template;
            $form = $this->form();
            unset($form[2]);
            return view('admin.transaksi.show-beli',compact('data','template','form','detail'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = Barang::all();
        $data = Transaksi::find($id);
        $detail = DetailTransaksi::where('transaksi_id',$id)->get();
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.transaksi.edit',compact('data','template','form','detail','barang'));
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function() use($request,$id){
            Transaksi::find($id)
                ->update([
                    'tanggal' => $request->tanggal,
                    'pelanggan_id' => $request->pelanggan_id,
                    'user_id' => Auth::user()->id,
                    'status' => $request->status,
                    'total' => $request->total
                ]);
            
            // DetailTransaksi::where('transaksi_id',$id)->delete();

            foreach($request->barang_id as $key => $value){
                $array['barang_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $id;

                // dd($request->detail_transaksi_id[$key]);
                if(!empty($request->detail_transaksi_id[$key])){
                    $detailTransaksi = DetailTransaksi::find($request->detail_transaksi_id);
                    $jumlah = $detailTransaksi->jumlah;
                    $array['barang_id'] = $value;
                    $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                    $array['jumlah'] = $request->jumlah[$key];
                    $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                    $array['transaksi_id'] = $id;

                    // jika jumlah barang sebelum diedit lebih besar dari transaksi sekarang
                    if($jumlah > $request->jumlah[$key]){
                        $barang = Barang::find($value);
                        $selisih = $jumlah - $request->jumlah[$key];
                        $stok = $barang->jumlah + $selisih;
                        $barang->update(['jumlah' => $stok]);
                    }else{
                        $barang = Barang::find($value);
                        $selisih = $request->jumlah[$key] - $jumlah;
                        $stok = $barang->jumlah - $selisih;
                        $barang->update(['jumlah' => $stok]);
                    }

                    $detailTransaksi->update($array);
                }
            }
        });

        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }

    public function print(Request $request){

        $dari_tgl = $request->dari_tgl;
        $sampai_tgl = $request->sampai_tgl;
        $data = Transaksi::whereBetween('tanggal',[$dari_tgl,$sampai_tgl])->get();
        $form = $this->form();
        $view = view('pdf.transaksi',compact('data','dari_tgl','sampai_tgl','form'))->render();
        $pdf = new Mpdf();
        $pdf->WriteHTML($view);

        return $pdf->Output('TRANSAKSI.pdf',\Mpdf\Output\Destination::INLINE);
    }
}
