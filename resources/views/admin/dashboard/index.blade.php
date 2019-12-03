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
        
           
        </section>
        <!-- /.content -->
    </div>

@endsection

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
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
    
            $('.changeable').change(function(){
                $('.filter').submit();
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