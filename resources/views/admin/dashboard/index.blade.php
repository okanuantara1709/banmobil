@extends('admin.layouts.app',[$template])
@push('css')

@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$template->title}}
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Home</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @if (auth()->user()->role == 'Operator')
                @if ( (int) \Carbon\Carbon::now()->format('d') < 11)
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">PERINGATAN</h4>
                        <p>SILAKAN MELAKUKAN PELAPORAN LAPORAN PERTANGGUNG JAWABAN </p>
                        <p class="mb-0"></p>
                    </div>
                @endif
            @endif
            
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info" style="background-color:#04abff">
                    <div class="inner">
                        <h3>{{$totalPenjualan}}</h3>
        
                        <p>Total Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger" style="background-color:#f00">
                        <div class="inner">
                            <h3>{{$totalPembelian}}</h3>
            
                            <p>Total Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success" style="background-color:#82ed73">
                    <div class="inner">
                        <h3>{{$totalProduksi}}</h3>
        
                        <p>Total Produksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning" style="background-color:#f6d421">
                    <div class="inner">
                        <h3>{{$totalPelanggan}}</h3>        
                        <p>Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                
            </div>
           
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('js')
  
@endpush