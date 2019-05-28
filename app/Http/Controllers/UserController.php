<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SatuanKerja;

class UserController extends Controller
{
    private $template = [
        'title' => 'User',
        'route' => 'admin.user',
        'menu' => 'user',
        'icon' => 'fa fa-users',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        $role = [
            ['value' => 'Admin','name' => 'Admin'],
            ['value' => 'Operator','name' => 'Operator'],
        ];

        $satker = SatuanKerja::select('id as value','nama_satker as name')
            ->get();

        return [
            ['label' => 'Nama Pengguna', 'name' => 'nama_user','view_index' => true],
            ['label' => 'Satuan Kerja','name' => 'satuan_kerja','type' => 'select','option' => $satker,'view_index' => 'true','view_relation' => 'satuan_kerja->nama_satker'],
            ['label' => 'Email','name' => 'email','view_index' => true],
            ['label' => 'Password','name' => 'password','type' => 'password'],
            ['label' => 'Role','name' => 'role','type' => 'select','option' => $role,'view_index' => true],
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
        $data = User::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        
    }
}
