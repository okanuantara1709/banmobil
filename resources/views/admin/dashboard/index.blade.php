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
<<<<<<< HEAD
            <!-- Small boxes (Stat box) -->            
            <!-- /.row -->
            <!-- Main row -->
            @if(AppHelper::access(['Admin']))
            <div class="row">
                <div class="col-md-12" style="padding-top:180px">                    
                    <h2><center>KANTOR PELAYANAN PERBENDAHARAAN NEGARA DENPASAR</center></h2>                                    
                </div>                
            </div>
            @else
            
=======
            @if (auth()->user()->role == 'Operator')
                @if ( (int) \Carbon\Carbon::now()->format('d') < 11)
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">PERINGATAN</h4>
                        <p>SILAKAN MELAKUKAN PELAPORAN LPJ</p>
                        <p class="mb-0"></p>
                    </div>
                @endif
>>>>>>> e7889b82d8696ef3ba3a7b254dfe729768605cc0
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header">
                            <div class="box-title">
                                SPM
                            </div>
                        </div>
                        <div class="box-body">
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{url('admin/dashboard')}}" method="get" id="form">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tahun</label>
                                                <select name="tahun" id="tahun" class="form-control">
                                                    @for ($i = 2016; $i <= 2019; $i++)
                                                        <option value="{{$i}}" {{request('tahun') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="tahunan" name="tahunan" {{request('tahunan') == 'on' ? 'checked' : ''}}> Tampilkan tahunan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Bulan</label>
                                                <select name="bulan" id="bulan" class="form-control">
                                                   @foreach ($bln as $key => $item)
                                                        <option value="{{$key}}" {{request('bulan') == $key ? 'selected' : ''}}>{{$item}}</option>
                                                   @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <div class="row" id="app">
                                        <h1 style="text-align:center" v-if="charts.length == 0">Tidak Ada Data</h1>
                                        <chart v-for="(data,index) in charts" :key="index" :data="data">

                                        </chart>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="fa fa-circle-o text-red"></i> Ditolak</li>
                                        <li><i class="fa fa-circle-o text-green"></i> Diterima</li>
                                        <li><i class="fa fa-circle-o text-yellow"></i> Pending</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header">
                            <div class="box-title">
                                Pemasukan dan Pengeluaran
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{url('admin/dashboard')}}" method="get" id="form_pp">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tahun</label>
                                                <select name="pp_tahun" id="pp_tahun" class="form-control">
                                                    @for ($i = 2016; $i <= 2019; $i++)
                                                        <option value="{{$i}}" {{request('pp_tahun') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="pp_tahunan" name="pp_tahunan" {{request('pp_tahunan') == 'on' ? 'checked' : ''}}> Tampilkan tahunan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Bulan</label>
                                                <select name="pp_bulan" id="pp_bulan" class="form-control">
                                                    @foreach ($bln as $key => $item)
                                                        <option value="{{$key}}" {{request('pp_bulan') == $key ? 'selected' : ''}}>{{$item}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8">
                                    <div class="row" id="appPP">
                                        <h1 style="text-align:center" v-if="charts.length == 0">Tidak Ada Data</h1>
                                        <chart v-for="(data,index) in charts" :key="index" :data="data">

                                        </chart>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="fa fa-circle-o text-red"></i> Pengeluran</li>
                                        <li><i class="fa fa-circle-o text-green"></i> Pemasukan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <template id="template">
        <div class="chart-responsive"> 
            <h4 style="text-align:center">@{{data.nama_satker}}</h4>
            <canvas ref="canva"></canvas>
        </div>
    </template>
@endsection

@push('js')
    <script src="{{asset('admin-lte')}}/bower_components/chart.js/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                charts: JSON.parse('{!!json_encode($data)!!}')
            },
            components:{
                'chart': {
                    template: '#template',
                    props: ['data'],
                    mounted() {
                        var canvas = $(this.$refs.canva).get(0).getContext('2d');
                        var chart = new Chart(canvas);
                        var pieData = [
                            {
                                value    : this.data.ditolak,
                                color    : '#f56954',
                                highlight: '#f56954',
                                label    : 'Ditolak'
                            },
                            {
                                value    : this.data.diterima,
                                color    : '#00a65a',
                                highlight: '#00a65a',
                                label    : 'Diterima'
                            },
                            {
                                value    : this.data.pending,
                                color    : '#f39c12',
                                highlight: '#f39c12',
                                label    : 'Pending'
                            },
                        ];
                        var pieOptions     = {
                            segmentShowStroke    : true,
                            segmentStrokeColor   : '#fff',
                            segmentStrokeWidth   : 1,
                            percentageInnerCutout: 50,
                            animationSteps       : 100,
                            animationEasing      : 'easeOutBounce',
                            animateRotate        : true,
                            animateScale         : false,
                            responsive           : true,
                            maintainAspectRatio  : false,
                            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                            tooltipTemplate      : '<%=value %> <%=label%> users'
                        };

                        chart.Doughnut(pieData,pieOptions);
                    },
                }
            }
        })

        var appPP = new Vue({
            el: '#appPP',
            data: {
                charts: JSON.parse('{!! json_encode($pp) !!}')
            },
            components: {
                'chart' : {
                    template: '#template',
                    props: ['data'],
                    mounted(){
                        var canvas = $(this.$refs.canva).get(0).getContext('2d');
                        var chart = new Chart(canvas);
                        var pieData = [
                            {
                                value    : this.data.pengeluaran,
                                color    : '#f56954',
                                highlight: '#f56954',
                                label    : 'Pengeluaran'
                            },
                            {
                                value    : this.data.pemasukan,
                                color    : '#00a65a',
                                highlight: '#00a65a',
                                label    : 'Pemasukan'
                            }
                        ];
                        var pieOptions     = {
                            segmentShowStroke    : true,
                            segmentStrokeColor   : '#fff',
                            segmentStrokeWidth   : 1,
                            percentageInnerCutout: 50,
                            animationSteps       : 100,
                            animationEasing      : 'easeOutBounce',
                            animateRotate        : true,
                            animateScale         : false,
                            responsive           : true,
                            maintainAspectRatio  : false,
                            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                            tooltipTemplate      : '<%=value %> <%=label%>'
                        };

                        chart.Doughnut(pieData,pieOptions);
                    }
                }
            }
        });
        $(function(){
            $('#tahun,#bulan,#tahunan').on('change',function(){
                $('#form').submit();
            });

            $('#pp_tahun,#pp_bulan,#pp_tahunan').on('change',function(){
                $('#form_pp').submit();
            });
        });
    </script>
@endpush