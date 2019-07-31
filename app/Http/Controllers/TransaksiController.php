<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ControllerTrait;
use Alert;
use App\Rekening;
use App\Transaksi;

class TransaksiController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'Transaksi',
        'route' => 'admin.transaksi',
        'menu' => 'transaksi',
        'icon' => 'fa fa-book',
        'theme' => 'skin-blue'
    ];

    private function form()
    {
        $satker = Rekening::select('id as value','nama_rekening as name')
            ->where('satker_id',auth()->user()->satker_id)
            ->get();
        $kategori = [
            [
                'value' => 'BP KAS',
                'name' => 'BP KAS'
            ],
            [ 
                'value' => 'BP UANG',
                'name' => 'BP UANG',
            ],
            [
                'value' => 'BP BPP',
                'name' => 'BP BPP',
            ],
            [
                'value' => 'BP UP',
                'name' => 'BP UP',
            ],
            [
                'value' => 'BP UANG',
                'name' => 'BP UANG',
            ],
            [
                'value' => 'BP IS BENDAHARA',
                'name' => 'BP IS BENDAHARA',
            ],
            [
                'value' => 'BP PAJAK',
                'name' => 'BP PAJAK',
            ],
            [
                'value' => 'BP LAIN LAIN',
                'name' => 'BP LAIN LAIN',
            ], 
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
                'label' => 'Tipe',
                'name' => 'tipe',
                'type' => 'select',
                'option' => [
                    [
                        'value' => 'Pengeluaran',
                        'name' => 'Pengeluaran'
                    ],
                    [
                        'value' => 'Pemasukan',
                        'name' => 'Pemasukan'
                    ]
                ],
                'view_index' => true,
            ],
            [
                'label' => 'Nama Petugas',
                'name' => 'nama_petugas',
                'view_index' => false
            ],
            [
                'label' => 'Nominal',
                'name' => 'nominal',
                'view_index' => false,
                'validation.store' => 'required|numeric',
                'validation.update' => 'required|numeric',
            ],
            [
                'label' => 'Tanggal Transaksi',
                'name' => 'tgl_transaksi',
                'type' => 'datepicker',
                'view_index' => true
            ],
            [
                'label' => 'Metode Pembayaran',
                'name' => 'metode_pembayaran',
                'view_index' => false,
                'type' => 'select',
                'option' => [
                    [
                        'value' => 'Transfer',
                        'name' => 'Transfer'
                    ],
                    [
                        'value' => 'Cek',
                        'name' => 'Cek'
                    ]
                ],
            ],
            [
                'label' => 'Nomor Cek',
                'name' => 'no_cek',
                'view_index' => false
            ],
            [
                'label' => 'Kategori',
                'name' => 'kategori',
                'type' => 'select',
                'option' => $kategori,
                'view_index' => false
            ],
            [
                'label' => 'Status',
                'name' => 'status',
                'type' => 'select',
                'option' => [
                    [
                        'value' => 'Sukses',
                        'name' => 'Sukses'
                    ],
                    [
                        'value' => 'Retur',
                        'name' => 'Retur'
                    ],
                    [
                        'value' => 'Gagal',
                        'name' => 'Gagal'
                    ]
                ],
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
        $data = Transaksi::all();
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
        $data = Transaksi::all();
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
        Transaksi::create($request->all());
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
        $data = Transaksi::find($id);
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
        $data = Transaksi::find($id);
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
        Transaksi::find($id)
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
        Transaksi::find($id)
            ->delete();
        Alert::make('success','Berhasil menghapus data');
        return redirect(route($this->template['route'].'.index'));
    }
}
