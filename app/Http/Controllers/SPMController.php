<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ControllerTrait;
use App\SPM;
use Alert;
use App\Rekening;

class SPMController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'SPM',
        'route' => 'admin.spm',
        'menu' => 'spm',
        'icon' => 'fa fa-book',
        'theme' => 'skin-blue'
    ];

    private function form()
    {
        $satker = Rekening::select('id as value','nama_rekening as name')
            ->where('satker_id',auth()->user()->satker_id)
            ->get();
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
                'view_index' => false,
            ],
            [
                'label' => 'Jenis SPM',
                'name' => 'jenis_spm',
                'view_index' => false
            ],
            [
                'label' => 'Nominal',
                'name' => 'nominal',
                'validation.store' => 'required|numeric',
                'validation.update' => 'required|numeric',
                'format' => 'rupiah',
                'view_index' => false
            ],
            [
                'label' => 'Status',
                'name' => 'status',
                'type' => 'hidden',
                'view_index' => true
            ],
            [
                'label' => 'File',
                'name' => 'file',
                'type' => 'file'
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
        $data = SPM::select('spm.*')
            ->join('rekening','rekening.id','=','spm.rekening_id')
            ->join('satker','satker.id','=','rekening.satker_id')
            ->where('satker.id',auth()->user()->satker_id)
            ->get();
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
        $this->formValidation($request,[
            'status' => 'nullable'
        ]);
        $data = $request->all();
        $data['status'] = 'Pending';
        $this->uploadFile($request,$data);
        SPM::create($data);
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
        $data = $request->all();
        $this->uploadFile($request,$data);
        SPM::find($id)
            ->update($data);
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
