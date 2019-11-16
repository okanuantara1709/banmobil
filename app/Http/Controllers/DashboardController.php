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

        $dari_tgl = empty($request->dari_tgl) ? date('Y-m-01') : $request->dari_tgl;
        $sampai_tgl = empty($request->sampai_tgl) ? date('Y-m-t') : $request->sampai_tgl;

        $data = Transaksi::whereBetween('tanggal',[$dari_tgl,$sampai_tgl])->get();

        return view('admin.dashboard.index',compact('template','totalProduksi','totalPembelian','totalPenjualan','totalPelanggan'));
    }
}
