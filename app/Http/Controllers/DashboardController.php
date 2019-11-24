<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Produksi;
use App\Transaksi;
use App\Pelanggan;
use AppHelper;
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

        $type = $request->type;
        
        $data = Transaksi::whereBetween('tanggal',[$dari_tgl,$sampai_tgl]);
        if($type == ''){
            $data = $data->get();
        }else{
            $data = $data->where('type',$type)->get();
        }


        $labels = [];
        $transaksi = [];
        for($i = 1;$i <= 12; $i++){
            $count = Transaksi::whereBetween('tanggal',[date("Y-m-d",strtotime("2019-$i-1")),date("Y-m-t",strtotime("2019-$i-1"))])
                    ->where('type','Penjualan')->get()->count();
            array_push($transaksi,$count);
            array_push($labels,AppHelper::bulan($i));
        }
        $labels = json_encode($labels);
        $transaksi = json_encode($transaksi);

        $labelsPembelian = [];
        $transaksiPembelian = [];
        for($i = 1;$i <= 12; $i++){
            $count = Transaksi::whereBetween('tanggal',[date("Y-m-d",strtotime("2019-$i-1")),date("Y-m-t",strtotime("2019-$i-1"))])
                    ->where('type','Penjualan')->get()->count();
            array_push($transaksiPembelian,$count);
            array_push($labelsPembelian,AppHelper::bulan($i));
        }
        $labelsPembelian = json_encode($labels);
        $transaksiPembelian = json_encode($transaksi);

        $form = app('App\Http\Controllers\TransaksiController')->form();
        return view('admin.dashboard.index',compact('template',
                                                    'data',
                                                    'dari_tgl',
                                                    'sampai_tgl',
                                                    'form',
                                                    'totalProduksi',
                                                    'totalPembelian',
                                                    'totalPenjualan',
                                                    'totalPelanggan',
                                                    'type',
                                                    'labels',
                                                    'transaksi',
                                                    'labelsPembelian',
                                                    'transaksiPembelian'
                                                ));
    }
}
