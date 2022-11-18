<x-app-layout>
    @push('js')
        <script>
            $('#id_barang').change(function() {
                var id_barang = $(this).val();
                if (id_barang != '0') {
                    $.ajax({
                        type: "GET",
                        url: "/totalpo?totalPo=" + id_barang,
                        dataType: 'JSON',
                        success: function(data) {
                            $('.total_id_barang').text(data);
                        }
                    })
                }else{
                    $('.total_id_barang').text(0);
                }
            });

            // Penjualan
            $('#id_penjualan').change(function() {
                var id_penjualan = $(this).val();
                if (id_penjualan != '0') {
                    $.ajax({
                        type: "GET",
                        url: "/total-penjualan?totalPo=" + id_penjualan,
                        dataType: 'JSON',
                        success: function(data) {
                            $('.total_id_penjualan').text(data);
                        }
                    })
                }else{
                    $('.total_id_penjualan').text(0);
                }
            })
            // Profit
            $('#id_profit').change(function() {
                var id_profit = $(this).val();
                if (id_profit != '0') {
                    $.ajax({
                        type: "GET",
                        url: "/total-profit?totalPo=" + id_profit,
                        dataType: 'JSON',
                        success: function(data) {
                            $('.total_id_profit').text(data);
                        }
                    })
                }else{
                    $('.total_id_profit').text(0);
                }
            })
        </script>
    @endpush
    @push('css')
        <style>
            .select2-container--default .select2-selection--single {
                border: 1px solid #ced4da;
                height: calc(2.25rem + 2px);
                padding: .375rem .75rem;
            }
            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 310px;
                max-width: 800px;
                margin: 1em auto;
            }

            #container {
                height: 500px;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #ebebeb;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }
        </style>
    @endpush
    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script></script>
        <script type="text/javascript">
            var a = {!! $barang !!};
            var series = a;
            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Jumlah Total Keuangan Seluruh Data Barang'
                },
                subtitle: {
                    text: 'Berdasarkan Kategori'
                },
                xAxis: {
                    categories: ['Penjualan', 'Purchase Order', 'Profit'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Rupiah (Rp)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' Rupiah'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: series,
            });
        </script>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
            <div class="row mb-3">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4 align-self-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center align-self-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Data Barang</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarang }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select name="barang" id="id_barang"
                                class="barang id_barang form-control py-3 @error('barang') is-invalid @enderror mb-2"
                                required>
                                <option value="0">Pilih Nama Barang</option>
                                @foreach ($data_barang as $item)
                                    <option value="{{ $item->id_barang }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Purchase Order
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" ><span id="total_id_barang" class="total_id_barang">0</span></div>
                                </div>
                                <div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-cart fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New User Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select name="barang" id="id_penjualan"
                                class="barang id_penjualan form-control py-3 @error('barang') is-invalid @enderror mb-2"
                                required>
                                <option value="0">Pilih Nama Penjualan</option>
                                @foreach ($data_barang as $item)
                                    <option value="{{ $item->id_barang }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Data Penjualan</div>
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><span id="total_id_penjualan" class="total_id_penjualan">0</span></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select name="barang" id="id_profit"
                                class="barang id_profit form-control py-3 @error('barang') is-invalid @enderror mb-2"
                                required>
                                <option value="0">Pilih Nama Barang</option>
                                @foreach ($data_barang as $item)
                                    <option value="{{ $item->id_barang }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Data Profit</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="total_id_profit" class="total_id_profit">0</span></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7 mt-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Total Keuangan</h6>
                        </div>
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
