<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    private $template = [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'menu' => 'dashboard',
        'icon' => 'fa fa-home',
        'theme' => 'skin-blue'
    ]; 

    public function index()
    {   
        $template = (object) $this->template;
        return view('admin.dashboard.index',compact('template'));
    }
}
