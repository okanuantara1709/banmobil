<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produksi;
use App\Barang;
use App\BahanBaku;
use App\BahanBakuBarang;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;
use Auth;
use DB;

class ProduksiController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Produksi',
        'route' => 'admin.produksi',
        'menu' => 'produksi',
        'icon' => 'fa fa-group',
        'theme' => 'skin-blue',
        'config' => [
            'index.delete.is_show' => false
        ]
    ];

    private function form()
    {
        $barang = Barang::select('id as value','nama as name')->get();

        return [
            [
                'label' => 'Barang',
                'name' => 'barang_id',
                'type' => 'select',
                'option' => $barang,
                'view_relation' => 'barang->nama',
                'view_index' => true,
            ],    
            [
                'label' => 'Operator',
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => Auth::user()->id,
                'view_index' => false,
            ],           
            [
                'label' => 'Jumlah Barang',
                'name' => 'jumlah',
                'type' => 'number',
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
        $data = Produksi::all();
        return view('admin.produksi.index',compact('template','form','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.produksi.create',compact('template','form'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->formValidation($request);
        $data = $request->all();
        
        $produksi = Produksi::create($data);
        $barang = Barang::find($request->barang_id);
        $barang->update(['jumlah' => $barang->jumlah + $request->jumlah]);
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.create.bahan-baku',$produksi->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Produksi::find($id);
        $bahanBakuBarang = BahanBakuBarang::where('produksi_id',$id)->get();
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.produksi.show',compact('data','template','form','bahanBakuBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Produksi::find($id);
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.produksi.edit',compact('data','template','form'));
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
        $this->formValidation($request);
        Produksi::find($id)
            ->update($request->all());
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
        Produksi::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }

    private function formBahanBaku($id)
    {
        
        $barang = BahanBaku::select('id as value',DB::raw("CONCAT(nama,' (',satuan,') ') as name"))->get();

        return [
            [
                'label' => 'Bahan Baku',
                'name' => 'bahan_baku_id',
                'type' => 'select',
                'option' => $barang,
                'view_index' => true,
            ],    
            [
                'label' => 'Operator',
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => Auth::user()->id,
                'view_index' => false,
            ], 
            [
                'label' => 'produksi_id',
                'name' => 'produksi_id',
                'type' => 'hidden',
                'value' => $id,
                'view_index' => false,
            ],           
            [
                'label' => 'Jumlah',
                'name' => 'jumlah',
                'type' => 'number',
                'view_index' => true,
            ],
        ];
    }

    public function createBahanBaku($id)
    {
        $template = (object) $this->template;
        $form = $this->formBahanBaku($id);
        $produksi = Produksi::find($id);
        $bahanBakuBarang = BahanBakuBarang::where('produksi_id',$id)->get();
        // dd($bahanBakuBarang);
        return view('admin.produksi.create-bahan-baku',compact('template','form','produksi','bahanBakuBarang'));
    }

    public function storeBahanBaku(Request $request,$id)
    {
        // dd($request->all());
        // $this->formValidation($request);
        $data = $request->all();
        $produksi = BahanBakuBarang::create($data);
        $bahanBaku = BahanBaku::find($request->bahan_baku_id);
        $bahanBaku->update(['jumlah' => $bahanBaku->jumlah - $request->jumlah]);
        Alert::make('success','Berhasil simpan data');
        return redirect()->back();
    }

    public function deleteBahanBaku($id){
        $bahanBakuBarang = BahanBakuBarang::find($id);
        $bahanBakuId = $bahanBakuBarang->bahan_baku_id;
        $bahanBaku = BahanBaku::find($bahanBakuId);
        $bahanBaku->update(['jumlah' => $bahanBaku->jumlah + $bahanBakuBarang->jumlah ]);
        BahanBakuBarang::destroy($id);

        Alert::make('success','Berhasil hapus  data');
        return redirect()->back();
    }
}
