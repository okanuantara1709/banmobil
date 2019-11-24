<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Pelanggan;
use App\Barang;
use App\BahanBaku;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;
use Auth;
use DB;
use App\DetailTransaksi;
use App\DetailTransaksiBeli;
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
       
        $pelanggan = Pelanggan::select('id as value','nama as name')->get();
        $status = [
            [
                'value' => 'Aktif',
                'name' => 'Aktif'
            ],
            [
                'value' => 'Batal',
                'name' => 'Batal'
            ],
        ];
        return [
            [
                'label' => 'Tanggal Transaksi',
                'name' => 'tanggal',
                'type' => 'datepicker',
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
                'label' => 'Pelanggan',
                'name' => 'pelanggan_id',
                'type' => 'select',
                'option' => $pelanggan,
                'view_relation' => 'pelanggan->nama',
                'view_index' => true,
            ],
            [
                'label' => 'Status Transaksi',
                'name' => 'status',
                'type' => 'select',
                'option' => $status,
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBeli()
    {
        $bahanBaku = BahanBaku::all();
        $template = (object) $this->template;
        $form = $this->form();
        unset($form[2]);
        return view('admin.transaksi.create-beli',compact('template','form','bahanBaku'));
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
        
        $return = DB::transaction(function() use($request){
            
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => Auth::user()->id,
                'type' => 'Penjualan',
                'status' => $request->status,
                'total' => $request->total
            ]);

            foreach($request->barang_id as $key => $value){
                $array['barang_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $transaksi->id;

                $barang = Barang::find($value);
                $stok = $barang->jumlah - $request->jumlah[$key];
                if($stok < 0){
                    Alert::make('danger',"Jumlah stok $barang->nama tidak mencukupi");
                    return false;
                }
                $barang->update(['jumlah' => $stok]);
                DetailTransaksi::create($array);
                return true;
            }
        });

        if($return){
            Alert::make('success','Berhasil simpan data');
            return redirect(route($this->template['route'].'.index'));
        }else{
            return redirect(route($this->template['route'].'.create'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBeli(Request $request)
    {
        // dd($request->all());
        
        $return = DB::transaction(function() use($request){
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'pelanggan_id' => null,
                'user_id' => Auth::user()->id,
                'type' => 'Pembelian',
                'status' => $request->status,
                'total' => $request->total
            ]);

            foreach($request->bahanBaku_id as $key => $value){
                $array['bahan_baku_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $transaksi->id;

                $bahanBaku = BahanBaku::find($value);
                $stok = $bahanBaku->jumlah + $request->jumlah[$key];                
                $bahanBaku->update(['jumlah' => $stok]);

                DetailTransaksiBeli::create($array);
                return true;
            }
        });
        
        
        if($return){
            Alert::make('success','Berhasil simpan data');
            return redirect(route($this->template['route'].'.index'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editBeli($id)
    {
        $bahanBaku = BahanBaku::all();
        $data = Transaksi::find($id);
        $detail = DetailTransaksiBeli::where('transaksi_id',$id)->get();
        // dd($detail);
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.transaksi.edit-beli',compact('data','template','form','detail','bahanBaku'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBeli(Request $request, $id)
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

            foreach($request->bahan_baku_id as $key => $value){
                $array['bahan_baku_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $id;
                // dd($request->detail_transaksi_id[$key]);
                if(!empty($request->detail_transaksi_id[$key])){
                    $detailTransaksi = DetailTransaksiBeli::find($request->detail_transaksi_id);
                    $jumlah = $detailTransaksi->jumlah;
                    $array['bahan_baku_id'] = $value;
                    $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                    $array['jumlah'] = $request->jumlah[$key];
                    $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                    $array['transaksi_id'] = $id;

                    // jika jumlah sebelum diedit lebih besar dari transaksi sekarang
                    if($jumlah > $request->jumlah[$key]){
                        $bahanBaku = BahanBaku::find($value);
                        $selisih = $jumlah - $request->jumlah[$key];
                        $stok = $bahanBaku->jumlah - $selisih;
                        $bahanBaku->update(['jumlah' => $stok]);
                    }else{
                        $bahanBaku = BahanBaku::find($value);
                        $selisih = $request->jumlah[$key] - $jumlah;
                        $stok = $bahanBaku->jumlah + $selisih;
                        $bahanBaku->update(['jumlah' => $stok]);
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
