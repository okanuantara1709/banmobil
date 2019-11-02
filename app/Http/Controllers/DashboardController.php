<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class DashboardController extends Controller
{

    private $template = [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'menu' => 'dashboard',
        'icon' => 'fa fa-home',
        'theme' => 'skin-blue'
    ]; 

    public function index(Request $request)
    {   
    $template = (object) $this->template;
       return view('admin.dashboard.index',compact('template'));
    }
}
