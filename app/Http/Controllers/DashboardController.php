<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Produksi;
use App\Transaksi;
use App\Pelanggan;
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
        $totalProduksi = Produksi::get()->count();
        $totalPembelian = Transaksi::where('type','Pembelian')->get()->count();
        $totalPenjualan = Transaksi::where('type','Penjualan')->get()->count();
        $totalPelanggan = Pelanggan::get()->count();
        return view('admin.dashboard.index',compact('template','totalProduksi','totalPembelian','totalPenjualan','totalPelanggan'));
    }
}
