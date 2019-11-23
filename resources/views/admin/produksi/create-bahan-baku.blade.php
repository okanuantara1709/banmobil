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
        <section class="content v-content" style="{{ $edit ? "display:none" : ""}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-list"></i> Detail Produksi</h3>                            
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:200px"></th>
                                        <th  style="width:20px"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td>:</td>
                                        <td>{{$produksi->barang->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td>:</td>
                                        <td>{{$produksi->jumlah}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
           <div class="row form-produksi" style="display:none">
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
                            <h3 class="box-title"><i class="{{$template->icon}}"></i> Form Tambah {{$template->title}}</h3>                            
                        </div>
                        <form action="{{route("$template->route".".store.bahan-baku",$produksi->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">                            
                                @foreach($form as $value)
                                    {!!Render::form($value)!!}
                                @endforeach
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Tambahkan Bahan Baku</button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
           </div>
           <div class="row">
                <div class="col-md-12">
                    {!!Alert::showBox()!!}
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-list"></i> Detail Bahan Baku</h3>      
                            <a href="#"  class=" btn-add btn btn-primary pull-right">Tambah Bahan Baku</a>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Bahan Baku</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanBakuBarang as $item)
                                    <tr>
                                        <td>{{$item->bahanBaku->nama}}</td>
                                        <td>{{$item->jumlah}}</td>
                                        <td>{{$item->bahanBaku->satuan}}</td>
                                        <td><a href="{{route('admin.produksi.delete.bahan-baku',$item->id)}}" class="btn btn-danger">Hapus</a></td>
                                    </tr>    
                                    @endforeach

                                </tbody>
                            </table>
                            <a href="{{route('admin.produksi.index')}}" class="btn btn-primary">Simpan Produksi</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content v-password" style="{{ !$edit ? "display:none" : ""}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header ">
                            <h4 class="header-title">Masukan password admin</h4>
                        </div>
                        <div class="box-body">
                            <form action="" class="form-password">
                                <div class="form-group">
                                    <label for="">Password :</label>
                                    <input type="password" class="form-control password" name="password">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
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
    <script src="{{asset('admin-lte/bower_components/ckeditor/ckeditor.js')}}"></script>
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
        $(document).ready(function(){
            $(".btn-add").click(function(){
                $(".form-produksi").toggle();
            })

            $(".form-password").submit(function(e){
                e.preventDefault();
                var password = $(".password").val();
                if(password == '123456'){
                    $(".v-password").fadeOut();
                    $(".v-content").fadeIn();
                }else{
                    alert("Password Salah")
                }
            })
        })
    })
    </script>
    <script>
        var map, marker;
         function initMap(){
            console.log('INIT MAP');
            var myLatLng = {lat: -8.604342, lng: 115.188044};         
            $('.lat').val(myLatLng.lat);
            $('.lng').val(myLatLng.lng); 
            map = new google.maps.Map(document.getElementById('google_map'), {
                zoom: 12,
                center: myLatLng
            });  

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable:true,
                title: 'Lokasi Desa'
            });

            google.maps.event.addListener(map,'click', function(event){
                marker.setPosition(event.latLng);
                console.log(event);
                $('.lat').val(event.latLng.lat);
                $('.lng').val(event.latLng.lng);                
            });
        }
        
    </script>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDX5i1N1RR3DSQTIRu0ZbIyTgorg7Rhg_g&callback=initMap"></script>
@endpush