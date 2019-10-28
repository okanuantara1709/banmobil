<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BahanBaku;
use App\Helpers\ControllerTrait;
use App\Helpers\Alert;

class BahanBakuController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Bahan Baku',
        'route' => 'bahan-baku',
        'menu' => 'bahan-baku',
        'icon' => 'fa fa-group',
        'theme' => 'skin-blue',
        'config' => [
            'index.delete.is_show' => false
        ]
    ];

    private function form()
    {
        $satuan = [
            ['value' => 'Kg','name' => 'Kg'],
            ['value' => 'Meter','name' => 'Meter'],
        ];

        $status = [
            [
                'value' => 'Aktif',
                'name' => 'Aktif'
            ],
            [
                'value' => 'Tidak Aktif',
                'name' => 'Tidak Aktif'
            ]
        ];

        return [
            [
                'label' => 'Nama Bahan',
                'name' => 'nama',
                'view_index' => true,
            ],
            [
                'label' => 'Jumlah',
                'name' => 'jumlah',
                'view_index' => true,
            ],
            [
                'label' => 'Satuan',
                'name' => 'satuan',
                'view_index' => true,
                'type' => 'select',
                'option' => $satuan
            ],
            [
                'label' => 'Status',
                'name' => 'status',
                'view_index' => true,
                'type' => 'select',
                'option' => $status
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
        $data = BahanBaku::all();
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
        BahanBaku::create($data);
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
        $data = BahanBaku::find($id);
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
        $data = BahanBaku::find($id);
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
        BahanBaku::find($id)
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
        BahanBaku::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));
    }
}
