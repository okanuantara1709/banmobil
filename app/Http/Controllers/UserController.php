<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SatuanKerja;
use App\Helpers\ControllerTrait;
use Alert;

class UserController extends Controller
{
    use ControllerTrait;

    private $template = [
        'title' => 'User',
        'route' => 'admin.user',
        'menu' => 'user',
        'icon' => 'fa fa-users',
        'theme' => 'skin-blue'
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
            [
                'label' => 'Nama Pengguna', 
                'name' => 'nama_user',
                'view_index' => true
            ],
            [
                'label' => 'Satuan Kerja',
                'name' => 'satker_id',
                'type' => 'select',
                'option' => $satker,
                'view_index' => 'true',
                'view_relation' => 'satuan_kerja->nama_satker'
            ],
            [
                'label' => 'Email',
                'name' => 'email',
                'view_index' => true,
                'validation.store' => 'required|unique:user,email'
            ],
            [
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password',
                'validation.store' => 'required|confirmed',
                'validation.update' => ''
            ],
            [
                'label' => 'Role',
                'name' => 'role',
                'type' => 'select',
                'option' => $role,
                'view_index' => true
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
        User::create([
            'nama_user' => $request->nama_user,
            'satker_id' => $request->satker_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
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
        $data = User::find($id);
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
        $data = User::find($id);
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
        if(trim($request->password) != ''){
            $data['password'] = bcrypt($request->password);
        }else{
            unset($data['password']);
        }
        unset($data['password_confirmation']);
        User::find($id)
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
        User::find($id)
            ->delete();
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index'));    
    }

    public function profile()
    {
        $template = (object) $this->template;
        $form = $this->form();
        $data = User::find(auth()->user()->id);
        return view('admin.master.profile',compact('template','form','data'));
    }

    public function setProfile(Request $request)
    {
        $this->formValidation($request,[
            'email' => 'required|unique:user,email,'.auth()->user()->id,
            'password' => 'nullable'
        ]);
        $data = $request->all();
        if(trim($request->password) != ''){
            $data['password'] = bcrypt($request->password);
        }else{
            unset($data['password']);
        }
        unset($data['password_confirmation']);
        User::find(auth()->user()->id)
            ->update($data);
        Alert::make('success','Berhasil simpan data');
        return back();  
    }
}
