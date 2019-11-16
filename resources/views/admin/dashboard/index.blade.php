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
            <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-filter"></i> Filter</h3>
                            </div>
                            <div class="box-body">
                                <form action="" class="filter">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Render::form([
                                                    'label' => 'Dari Tanggal',
                                                    'type' => 'datepicker',
                                                    'class' => 'changeable',
                                                    'name' => 'dari_tgl',
                                                    'value' => $dari_tgl
                                                ]) 
                                            !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Render::form([
                                                    'label' => 'Sampai Tanggal',
                                                    'type' => 'datepicker',
                                                    'class' => 'changeable',
                                                    'name' => 'sampai_tgl',
                                                    'value' => $sampai_tgl
                                                ]) 
                                            !!}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="{{$template->icon}}"></i> List {{$template->title}}</h3>
                            
                        </div>
                        <div class="box-body">
                            <table class="table" id="datatables">
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        @foreach ($form as $item)
                                            @if (array_key_exists('view_index',$item) && $item['view_index'])
                                            @if(array_key_exists('format',$item) && $item['format'] == 'rupiah')
                                                <td>{{$item['label']}} (Rp)</td>
                                            @else
                                                <td>{{$item['label']}}</td>
                                            @endif
                                            @endif
                                        @endforeach
                                        <td>Opsi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $row)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            @foreach ($form as $item)
                                                @if (array_key_exists('view_index',$item) && $item['view_index'])
                                                    <td @if(array_key_exists('format',$item) && $item['format'] == 'rupiah') style="text-align:right" @endif>
                                                        @if (array_key_exists('view_relation',$item))
                                                        {{ AppHelper::viewRelation($row,$item['view_relation']) }}
                                                        @else
                                                            @if(array_key_exists('format',$item) && $item['format'] == 'rupiah')
                                                                {{number_format($row->{$item['name']},2,',','.')}}
                                                            @else
                                                            {{ $row->{$item['name']} }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td>
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <a href="{{route('admin.transaksi.print',['dari_tgl' => $dari_tgl,'sampai_tgl' => $sampai_tgl])}}" class="btn btn-default"><i class="fa fa-print"></i> Cetak Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
           
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('js')
  
<script>
        $(function () {
            $('#datatables').DataTable()
    
            $('#full-datatables').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })
    
            $('.datepicker').datepicker({
                autoclose: true,
                format : 'yyyy-mm-dd'
            }).on('changeDate',function(e){
                $('.filter').submit();
            })
        })
        </script>
@endpush