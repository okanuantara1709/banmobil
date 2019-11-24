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
                    {!!Alert::showBox()!!}
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="{{$template->icon}}"></i> Form Tambah {{$template->title}}</h3>                            
                        </div>
                        <form action="{{route("$template->route".".store")}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">                            
                                @foreach($form as $value)
                                    {!!Render::form($value)!!}
                                @endforeach
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="transaksi-body">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer">
                                <h4>Total : <span class="total">0</span></h4>
                                <input type="hidden" name="total" class="total-input">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
           </div>
        </section>
        <section class="ex-form-transkasi" style="display:none">
            <div class="form-transaksi " style="display:table-row">
                <div style="display:table-cell;vertical-align:top;padding:5px">
                    <select name="barang_id[]" class="form-control barang" id="">
                        @foreach ($barang as $item)
                            <option value="{{$item->id}}" data-harga="{{$item->harga}}">{{$item->nama}}</option>    
                        @endforeach
                    </select>
                </div>
                <div style="display:table-cell;vertical-align:top;padding:5px">
                    <input type="text" name="harga[]" readonly class="form-control harga">
                </div>
                <div style="display:table-cell;vertical-align:top;padding:5px">
                    <input type="text" name="jumlah[]" class="form-control jumlah">
                </div>
                <div style="display:table-cell;vertical-align:top;padding:5px">
                    <input type="text" name="subtotal[]" readonly class="form-control subtotal">
                </div>
                <div style="display:table-cell;vertical-align:top;padding:5px">
                    <button type="button" class="btn btn-success btn-add"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-danger delete"><i class="fa fa-close"></i></button>
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
    })
    </script>
    <script>    
        $(document).ready(function(){

            function addCommas(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
            function addForm(){
                var htmlForm = $(".ex-form-transkasi").html();
                console.log(htmlForm);
                $(".transaksi-body").append(htmlForm);
                looping()
            }
            
            addForm();

            $(document).on('click','.btn-add',function(){
                addForm()
            })

            $(document).on('keyup','.jumlah',function(event){
                while(! /^(([0-9]+)((\.|,)([0-9]{0,2}))?)?$/.test($(this).val())){
                    $(this).val($(this).val().slice(0, -1));
                }
                looping()
            })

            $(document).on('change','.barang',function(){
                looping()
            })

            $(document).on('click','.delete',function(){
                var r = confirm("Yakin hapus ?");
                if(r == true){
                    $(this).closest('.form-transaksi').remove();
                } 
            })

            function looping(){
                var total = 0;
                $(".transaksi-body > .form-transaksi").each(function(index, data){
                    var harga = $(this).find('.barang').children("option:selected").attr('data-harga');
                    var jumlah = $(this).find('.jumlah').val() || 0;
                    var subtotal = jumlah*harga;
                    total += subtotal;

                    $(this).find('.harga').val(addCommas(harga));
                    $(this).find('.subtotal').val(addCommas(subtotal));
                    $(".total").html(addCommas(total))
                    $('.total-input').val(total);
                })
            }
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