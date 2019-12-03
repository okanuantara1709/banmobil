<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Kategori;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;

class BarangController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Barang',
        'route' => 'admin.barang',
        'menu' => 'barang',
        'icon' => 'fa fa-group',
        'theme' => 'skin-blue',
        'config' => [
            'index.delete.is_show' => false
        ]
    ];

    private function form()
    {
        $kategori = Kategori::select('id as value','nama as name')->get();

       

        return [
            [
                'label' => 'Nama Barang',
                'name' => 'nama',
                'view_index' => true,
            ],           
            [
                'label' => 'Jumlah',
                'name' => 'jumlah',
                'type' => 'number',
                'view_index' => true,
            ],
            [
                'label' => 'Harga (Rp.)',
                'name' => 'harga',
                'type' => 'number',
                'view_index' => true,
            ],
            [
                'label' => 'Kategori',
                'name' => 'kategori_id',
                'view_index' => true,
                'type' => 'select',
                'option' => $kategori
            ]
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
        $data = Barang::all();
        return view('admin.master.index',compact('template','form','data'));
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
        return view('admin.master.create',compact('template','form'));
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
        Barang::create($data);
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
        $data = Barang::find($id);
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.master.show',compact('data','template','form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Barang::find($id);
        $template = (object) $this->template;
        $form = $this->form();
        return view('admin.master.edit',compact('data','template','form'));
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
        Barang::find($id)
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
        Barang::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }
}
