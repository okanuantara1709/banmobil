<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\SatuanKerja;
class DashboardController extends Controller
{

    private $template = [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'menu' => 'dashboard',
        'icon' => 'fa fa-home',
        'theme' => 'skin-red'
    ]; 

    public function index(Request $request)
    {   
        $data = [];
        $satker = SatuanKerja::all();
        $bln = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $tahun = $request->has('tahun') ? $request->tahun : 2016;
        $bulan = $request->has('bulan') ? $request->bulan : 1;
        if(auth()->user()->satker_id == null){
            $data = DB::table('spm')
                ->select(DB::raw('
                    satker.nama_satker,
                    SUM(CASE WHEN spm.status = "Diterima" THEN 1 ELSE 0 END) AS diterima,
                    SUM(CASE WHEN spm.status = "Pending" THEN 1 ELSE 0 END) AS pending,
                    SUM(CASE WHEN spm.status = "Ditolak" THEN 1 ELSE 0 END) as ditolak
                '))
                ->join('rekening','rekening.id','=','spm.rekening_id')
                ->join('satker','satker.id','=','rekening.satker_id')
                ->groupBy('satker.id')
                ->whereRaw("YEAR(spm.tanggal_surat) = $tahun")
                ->whereRaw("MONTH(spm.tanggal_surat) = $bulan")
                ->get();
        }else{
            $data = DB::table('spm')
                ->select(DB::raw('
                    satker.nama_satker,
                    SUM(CASE WHEN spm.status = "Diterima" THEN 1 ELSE 0 END) AS diterima,
                    SUM(CASE WHEN spm.status = "Pending" THEN 1 ELSE 0 END) AS pending,
                    SUM(CASE WHEN spm.status = "Ditolak" THEN 1 ELSE 0 END) as ditolak
                '))
                ->join('rekening','rekening.id','=','spm.rekening_id')
                ->join('satker','satker.id','=','rekening.satker_id')
                ->groupBy('satker.id')
                ->where('satker.id',auth()->user()->satker_id)
                ->whereRaw("YEAR(spm.tanggal_surat) = $tahun")
                ->whereRaw("MONTH(spm.tanggal_surat) = $bulan")
                ->get();
        }
        $template = (object) $this->template;
        return view('admin.dashboard.index',compact('template','data','satker','bln'));
    }
}
