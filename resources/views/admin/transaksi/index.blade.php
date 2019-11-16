@extends('admin.layouts.app')
@push('css')
    <style>
        /* #datatables th,#datatables td, #datatables thead{
            border : 1px solid #b9b9b9;
            border-bottom: 1px solid #b9b9b9 !important;
        }
        #datatables th{
            text-align: center;
        } */
    </style>
@endpush
@section('content')
    @php
        @$config = $template->config == null ? [] : $template->config;
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$template->title}}                
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$template->title}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
                    {!!Alert::showBox()!!}
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="{{$template->icon}}"></i> List {{$template->title}}</h3>
                            <a href="{{route("$template->route".'.createBeli')}}" style="margin-left:10px" class="btn btn-primary pull-right {{AppHelper::config($config,'index.create.is_show') ? AppHelper::config($config,'index.create.is_show') : 'hidden'}}">
                                <i class="fa fa-plus"></i> Tambah {{$template->title}} Beli
                            </a>
                            <a href="{{route("$template->route".'.create')}}" class="btn btn-success pull-right {{AppHelper::config($config,'index.create.is_show') ? AppHelper::config($config,'index.create.is_show') : 'hidden'}}">
                                <i class="fa fa-plus"></i> Tambah {{$template->title}} Jual
                            </a>
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
                                                @if($row->type == 'Pembelian')
                                                    <a href="{{route("$template->route".'.editBeli',[$row->id])}}" class="btn btn-success btn-sm {{AppHelper::config($config,'index.edit.is_show') ? '' : 'hidden'}}">Ubah</a>
                                                @else
                                                    <a href="{{route("$template->route".'.edit',[$row->id])}}" class="btn btn-success btn-sm {{AppHelper::config($config,'index.edit.is_show') ? '' : 'hidden'}}">Ubah</a>
                                                @endif
                                                <a href="{{route("$template->route".'.show',[$row->id])}}" class="btn btn-info btn-sm {{AppHelper::config($config,'index.show.is_show') ? '' : 'hidden'}}">Lihat</a>
                                                <a href="#" class="btn btn-danger btn-sm {{AppHelper::config($config,'index.delete.is_show') ? '' : 'hidden'}}" onclick="confirm('Lanjutkan ?') ? $('#frmDelete{{$row->id}}').submit() : ''">Hapus</a>
                                                <form action="{{route("$template->route".'.destroy',[$row->id])}}" method="POST" id="frmDelete{{$row->id}}">
                                                    {{ csrf_field() }}
                                                    @method('DELETE')
                                                </form>
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
    <!-- /.content-wrapper -->
@endsection
@push('js')
    <!-- page script -->
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

