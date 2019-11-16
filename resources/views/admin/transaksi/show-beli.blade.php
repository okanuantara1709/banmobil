@extends('admin.layouts.app')
@push('css')

@endpush
@section('content')
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="{{$template->icon}}"></i> Detail {{$template->title}}</h3>                            
                        </div>
                        <div class="box-body">  
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px"></th>
                                        <th style="width:20px"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tbody>                                                                                       
                                       @foreach ($form as $item)
                                            @if (array_key_exists('type',$item) && $item['type'] == 'password')
                                            
                                            @elseif(array_key_exists('type',$item) && $item['type'] == 'file')
                                            <tr>
                                                <td>{{$item['label']}}</td>
                                                <td>:</td>
                                                <td>
                                                    <a href="{{asset($data->{$item['name']})}}" target="_blank">{{$data->{$item['name']} }}</a>
                                                </td>
                                            </tr>
                                            @elseif(array_key_exists('view_relation',$item) && !empty($item['view_relation']))
                                            <tr>
                                                <td>{{$item['label']}}</td>
                                                <td>:</td>
                                                <td>
                                                    {{AppHelper::viewRelation($data,$item['view_relation'])}}
                                                </td>
                                            </tr>
                                            @elseif(array_key_exists('format',$item) && !empty($item['format']))
                                                <tr>
                                                    @if ($item['format'] == 'rupiah')
                                                        <td>{{$item['label']}}</td>
                                                        <td>:</td>
                                                        <td>Rp. {!! number_format($data->{$item['name']},2,',','.') !!}</td>
                                                    @endif
                                                </tr>
                                            @else
                                            <tr>
                                                <td>{{$item['label']}}</td>
                                                <td>:</td>
                                                <td>{!! $data->{$item['name']} !!}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan Baku</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->bahanBaku->nama}}</td>
                                            <td>{{number_format($item->harga)}}</td>
                                            <td>{{$item->jumlah}}</td>
                                            <td>{{number_format($item->subtotal)}}</td>
                                        </tr>   
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">                                
                            <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
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
        var map, marker;
         function initMap(){
            console.log('INIT MAP');
            var myLatLng = {lat: {{$data->lat}}, lng: {{$data->lng}} };         
            $('.lat').val(myLatLng.lat);
            $('.lng').val(myLatLng.lng); 
            map = new google.maps.Map(document.getElementById('google_map'), {
                zoom: 16,
                center: myLatLng
            });  

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable:false,
                title: 'Lokasi Desa'
            });
            marker.setPosition(event.latLng);
        }
    </script>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDX5i1N1RR3DSQTIRu0ZbIyTgorg7Rhg_g&callback=initMap"></script>
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
    })
    </script>
@endpush