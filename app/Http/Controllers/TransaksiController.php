<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Pelanggan;
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

    private function form()
    {
       
        $pelanggan = Pelanggan::select('id as value','nama as name')->get();
        $status = [
            [
                'value' => 'Belum Selesai',
                'name' => 'Belum Selesai'
            ],
            [
                'value' => 'Selesai',
                'name' => 'Selesai'
            ],
        ];
        return [
            [
                'label' => 'Tanggal Pemesanan',
                'name' => 'tanggal',
                'type' => 'datepicker',
                'value' => date('Y-m-d'),
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
                'label' => 'Status Pemesanan',
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
    public function index()
    {
        $template = (object) $this->template;
        $form = $this->form();

        $dari_tgl = empty($request->dari_tgl) ? date('Y-m-01') : $request->dari_tgl;
        $sampai_tgl = empty($request->sampai_tgl) ? date('Y-m-t') : $request->sampai_tgl;

        $data = Transaksi::whereBetween('tanggal',[$dari_tgl,$sampai_tgl])->get();
        return view('admin.transaksi.index',compact('template','form','data','dari_tgl','sampai_tgl'));
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
        
        DB::transaction(function() use($request){
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => Auth::user()->id,
                'status' => $request->status,
                'total' => $request->total
            ]);

            foreach($request->barang_id as $key => $value){
                $array['barang_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $transaksi->id;
                DetailTransaksi::create($array);
            }
        });
        
        

        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
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
        $detail = DetailTransaksi::where('transaksi_id',$id)->get();
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.transaksi.show',compact('data','template','form','detail'));
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
            
            DetailTransaksi::where('transaksi_id',$id)->delete();

            foreach($request->barang_id as $key => $value){
                $array['barang_id'] = $value;
                $array['harga'] = AppHelper::numberOnly($request->harga[$key]);
                $array['jumlah'] = $request->jumlah[$key];
                $array['subtotal'] = AppHelper::numberOnly($request->subtotal[$key]);
                $array['transaksi_id'] = $id;
                DetailTransaksi::create($array);
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
