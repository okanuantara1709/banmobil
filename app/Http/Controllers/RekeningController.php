<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ControllerTrait;
use App\SatuanKerja;
use App\Rekening;
use Alert;

class RekeningController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Rekening',
        'route' => 'admin.rekening',
        'menu' => 'rekening',
        'icon' => 'fa fa-book',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        $satker = SatuanKerja::select('id as value','nama_satker as name')
            ->get();
        $bulan = [];
        return [
            [
                'label' => 'Satuan Kerja',
                'name' => 'satker_id',
                'type' => 'select',
                'option' => $satker,
                'view_index' => true,
                'view_relation' => 'satuan_kerja->nama_satker'
            ],
            [
                'label' => 'Nama Rekening',
                'name' => 'nama_rekening',
                'view_index' => true,
            ],
            [
                'label' => 'Nomor Rekening',
                'name' => 'no_rekening',
                'view_index' => true,
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
        $data = Rekening::all();
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
        $data = Rekening::all();
        return view('admin.master.create',compact('template','form','data'));
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
        Rekening::create($request->all());
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
        $template = (object) $this->template;
        $form = $this->form();
        $data = Rekening::find($id);
        return view('admin.master.show',compact('template','form','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = (object) $this->template;
        $form = $this->form();
        $data = Rekening::find($id);
        return view('admin.master.edit',compact('template','form','data'));
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
        Rekening::find($id)
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
        Rekening::find($id)
            ->delete();
        Alert::make('success','Berhasil menghapus data');
        return redirect(route($this->template['route'].'.index'));
    }
}
