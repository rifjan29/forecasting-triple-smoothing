<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Peramalan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Peramalan</li>
                    <li class="breadcrumb-item active" aria-current="page">Profit</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <div type="button" class="btn btn-primary w-100 d-flex">
                                        MAPE <span class="badge badge-light mx-2">
                                            <h5 class="font-weight-bold m-0">{{ number_format($mape, 2, ',', '.') }}%</h5>
                                        </span>
                                        <span class="sr-only">unread messages</span>
                                    </div>
                                    <label></label>

                                </div>
                                <div class="col-md-6 align-items-center">
                                    <div type="button" class="btn btn-primary w-100">
                                        MAD <span class="badge badge-light">
                                            <h5 class="font-weight-bold m-0">{{ number_format($mad, 2, ',', '.') }}</h5>
                                        </span>
                                        <span class="sr-only">unread messages</span>
                                    </div>
                                    <label></label>

                                </div>
                                <div class="col-md-6 align-self-center">
                                    <div type="button" class="btn btn-primary w-100">
                                        MSE <span class="badge badge-light">
                                            <h5 class="font-weight-bold m-0">{{ number_format($mse, 2, ',', '.') }}</h5>
                                        </span>
                                        <span class="sr-only">unread messages</span>
                                    </div>
                                    <label></label>

                                </div>
                                <div class="col-md-6 align-self-center">
                                    <div type="button" class="btn btn-primary w-100">
                                        MFE <span class="badge badge-light">
                                            <h5 class="font-weight-bold m-0">{{ number_format($mfe, 2, ',', '.') }}</h5>
                                        </span>
                                        <span class="sr-only">unread messages</span>
                                    </div>
                                    <label></label>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <div type="button" class="btn btn-info w-100">
                                        Alpha <span class="badge badge-light w-100">
                                            <h5 class="font-weight-bold m-0">{{ $alpha }}</h5>
                                        </span>
                                        <span class="sr-only">unread messages</span>
                                    </div>
                                    <label></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column w-100">
                                        <div>
                                            <div class="btn btn-warning  w-100">
                                                <small>Peramalan <strong>{{ $get_periode }}</strong> periode pada
                                                    <strong>{{ $periode }}</strong></small>
                                                <span class="font-weight-bold m-0 badge badge-light w-100">
                                                    <h5 class="font-weight-bold m-0">Rp.{{ number_format($forecast, 2, ',', '.') }}</h5>
                                                </span>
                                            </div>
                                        </div>
                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Profit</h6>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('Berhasil'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h6><i class="fas fa-check"></i><b> Success!</b></h6>
                                    {{ $message }}
                                </div>
                            @endif

                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush" id="dataTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Periode</th>
                                            <th>Data Aktual</th>
                                            <th>Smoothing Pertama</th>
                                            <th>Smoothing Kedua</th>
                                            <th>Parameter Pemulusan (at)</th>
                                            <th>Parameter Pemulusan Trend Linier (bt)</th>
                                            <th>Peramalan</th>
                                            <th>Xt-Ft/Xt</th>
                                            <th>|Xt-Ft|/n</th>
                                            <th>(Xt-Ft)<sup>2</sup>/n</th>
                                            <th>(Xt-Ft)/n</th>
                                            <th>MR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item['periode'] }}</td>
                                                <td>Rp{{ number_format($item['aktual'], 2, ',', '.') }}</td>
                                                <td>{{ number_format($item['smoothing pertama'], 2, ',', '.') }}</td>
                                                <td>{{ number_format($item['smoothing kedua'], 2, ',', '.') }}</td>
                                                <td>{{ number_format($item['at'], 2, ',', '.') }}</td>
                                                <td>{{ number_format($item['bt'], 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format((float) $item['peramalan'], 2, ',', '.') }}</td>
                                                <td>{{ number_format((float) $item['xtft'], 2, ',', '.') }}</td>
                                                <td>{{ number_format((float) $item['xtftn'], 2, ',', '.') }}</td>
                                                <td>{{ number_format((float) $item['xtft2n'], 2, ',', '.') }}</td>
                                                <td>{{ number_format((float) $item['xtftn2'], 2, ',', '.') }}</td>
                                                <td>{{ number_format((float) $item['mr'], 2, ',', '.') }}</td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Pengendali Moving Range</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" id="mr">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Data Profit</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" id="grafik">
                            </div>
                        </div>
                    </div>
                </div>
                <!--Row-->

            </div>

            <!-- Modal hapus -->
            <form id="delete_form" action="" method="POST">
                @csrf
                @method('delete')
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Hapus data
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin ingin menghapus data ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tidak</button>
                                <button type="submit" class="btn btn-primary">Iya</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
    @push('js')
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script type="text/javascript">
         document.addEventListener('DOMContentLoaded', function () { 
            const chart = Highcharts.chart('mr', {
                title: {
                    text: 'Grafik Pengendali Moving Range'
                },
                subtitle: {
                    text: 'Data Profit'
                },
                xAxis: {
                    categories: [
                        @foreach ($data as $item)
                            '{{ $item['periode'] }}',
                        @endforeach
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Profit'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true
                    }
                },
                series: [{
                        name: 'MR',
                        data: [
                            @foreach ($data as $item)
                                @if ($item['mr'] != null)
                                    {{ $item['mr'] }},
                                @endif
                            @endforeach
                        ]
                    },
                    {
                        name: 'LCL',
                        data: [
                            {{ str_repeat("$lcl,", $jumlah) }}
                        ]
                    },
                    {
                        name: 'UCL',
                        data: [
                            {{ str_repeat("$ucl,", $jumlah) }}
                        ]
                    },
                ],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
         });
        
            Highcharts.chart('grafik', {
                title: {
                    text: 'Grafik Double Exponential Smoothing'
                },
                subtitle: {
                    text: 'Data Profit'
                },
                xAxis: {
                    categories: [
                        @foreach ($data as $item)
                            '{{ $item['periode'] }}',
                        @endforeach
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Profit'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true
                    }
                },
                series: [{
                        name: 'Data Aktual',
                        data: [
                            @foreach ($data as $item)
                                {{ $item['aktual'] }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Peramalan',
                        data: [
                            @foreach ($data as $item)
                                {{ (float) $item['peramalan'] }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Rata-Rata',
                        data: [
                            {{ str_repeat("$rata,", $jumlah) }}
                        ]
                    },
                ],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        </script>
        
        <script type="text/javascript">
           
        </script>
    @endpush
</x-app-layout>
