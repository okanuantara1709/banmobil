<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ControllerTrait;
use App\SPM;
use Alert;
use App\Rekening;

class SPMAdminController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'SPM',
        'route' => 'admin.spm-admin',
        'menu' => 'spm-admin',
        'icon' => 'fa fa-book',
        'theme' => 'skin-red',
        'config' => [
            'index.show.is_show' => false,
            'index.create.is_show' => false,
            'index.delete.is_show' => false,
        ]
    ];

    private function form()
    {
        $satker = Rekening::select('id as value','nama_rekening as name')
            ->get();
        $status = [
            [
                'value' => 'Diproses',
                'name' => 'Diproses'
            ],
            [
                'value' => 'Diterima',
                'name' => 'Diterima'
            ],
            [
                'value' => 'Ditolak',
                'name' => 'Ditolak'
            ]
        ];
        return [
            [
                'label' => 'Rekening',
                'name' => 'rekening_id',
                'type' => 'select',
                'option' => $satker,
                'view_index' => true,
                'view_relation' => 'rekening->nama_rekening'
            ],
            [
                'label' => 'Tanggal Surat',
                'name' => 'tanggal_surat',
                'type' => 'datepicker',
                'view_index' => true,
            ],
            [
                'label' => 'Nomor Surat',
                'name' => 'no_surat',
                'view_index' => true,
            ],
            [
                'label' => 'Jenis SPM',
                'name' => 'jenis_spm',
                'view_index' => true
            ],
            [
                'label' => 'Nominal',
                'name' => 'nominal',
                'validation.store' => 'required|numeric',
                'validation.update' => 'required|numeric',
                'view_index' => true
            ],
            [
                'label' => 'Status',
                'name' => 'status',
                'type' => 'select',
                'option' => $status,
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
        $data = SPM::all();
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
        $data = SPM::all();
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
        SPM::create($request->all());
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
        $data = SPM::find($id);
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
        $data = SPM::find($id);
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
        SPM::find($id)
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
        SPM::find($id)
            ->delete();
        Alert::make('success','Berhasil menghapus data');
        return redirect(route($this->template['route'].'.index'));
    }
}
