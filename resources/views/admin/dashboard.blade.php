@extends('layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @isset($dataKurang)
                    <div class="col-sm" id="notifyAlert">
                        <div data-notify="container" data-notify-position="top-center" class="alert alert-warning mt-3 ml-auto" role="alert">
                            <span data-notify="title">Peringatan</span>
                            <span data-notify="message">Terdapat Barang Kurang Dari Stock Minimal Inventori !!!!</span>
                            <button type="button" aria-hidden="true" onclick="closeNotify()" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;">×</button>
                            <a href="/barang-kurang" data-notify="url" style="height: 100%; left: 0px; position: absolute; top: 0px; width: 100%; z-index: 1032;"></a>
                        </div>
                    </div>
                    <script>
                        function closeNotify(){
                            document.getElementById("notifyAlert").style.display="none";
                        }
                    </script>
                    @endisset
                </div>
            </div>
            <div class="page-inner pb-0">
                <div class="page-header">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>

            <div class="row p-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>
                                Barang Masuk
                            </h4>
                        </div>
                        <div id="barangMasuk"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>
                                Barang Keluar
                            </h4>
                        </div>
                        <div id="barangKeluar"></div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        // Create the chart
        $(document).ready(function() {
            Highcharts.chart('barangMasuk', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Data Barang Masuk Bulan {{date("F Y")}}'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    categories: <?= json_encode($namaBarang) ?>,
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Barang'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.date} <br>{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },
                series: [{
                    name: "Jumlah Barang",
                    colorByPoint: true,
                    data: <?= json_encode($barangMasuk) ?>
                }],

            });
        });

        $(document).ready(function() {
            Highcharts.chart('barangKeluar', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Data Barang Keluar Bulan {{date("F Y")}}'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    categories: <?= json_encode($namaBarang) ?>,
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Barang'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.date} <br>{point.name}</span>: <b>{point.y:.0f}</b><br/>'
                },
                series: [{
                    name: "Jumlah Barang",
                    colorByPoint: true,
                    data: <?= json_encode($barangKeluar) ?>
                }],

            });
        });
    </script>
@endpush
