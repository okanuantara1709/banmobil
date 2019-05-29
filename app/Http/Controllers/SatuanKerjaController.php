<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SatuanKerja;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;

class SatuanKerjaController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Satuan Kerja',
        'route' => 'admin.satuan-kerja',
        'menu' => 'satuan-kerja',
        'icon' => 'fa fa-group',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        $role = [
            ['value' => 'Admin','name' => 'Admin'],
            ['value' => 'Operator','name' => 'Operator'],
        ];

        return [
            [
                'label' => 'Nama Satuan Kerja',
                'name' => 'nama_satker',
                'view_index' => true,
            ],
            [
                'label' => 'Alamat',
                'name' => 'alamat',
                'view_index' => true
            ],
            [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'view_index' => true,
                'validation.store' => 'required|email'
            ],
            [
                'label' => 'Telepon',
                'name' => 'telepon',
                'view_index' => true
            ],
            [
                'label' => 'Lembaga Kementrian',
                'name' => 'kementrian_lembaga',
                'view_index' => true
            ],
            [
                'label' => 'No KRWS & Kewenangan',
                'name' => 'no_krws_dan_kewenangan',
                'type' => 'textarea',
                'view_index' => true
            ],
            [
                'label' => 'Nama Bendahara',
                'name' => 'nama_bendahara',
                'view_index' => true
            ],
            [
                'label' => 'Status',
                'name' => 'status',
                'view_index' => true
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
        $data = SatuanKerja::all();
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
        SatuanKerja::create($data);
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
        $data = SatuanKerja::find($id);
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
        $data = SatuanKerja::find($id);
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
        SatuanKerja::find($id)
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
        SatuanKerja::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }
}
