<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
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
                                            <th>No.</th>
                                            <th>Nama Barang</th>
                                            <th>Bulan</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penjualan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @php
                                                    $barang = \App\Models\Barang::select('nama', 'id_satuan')
                                                        ->where('id', $item->id_barang)
                                                        ->get();
                                                @endphp
                                                @foreach ($barang as $itembarang)
                                                    <td>{{ $itembarang->nama }}</td>
                                                    <td>{{ $item->bulan . '-' . $item->tahun }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    @php
                                                        $satuan = \App\Models\Satuan::select('satuan')
                                                            ->where('id', $itembarang->id_satuan)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($satuan as $itemsatuan)
                                                        <td>{{ $itemsatuan->satuan }}</td>
                                                    @endforeach
                                                @endforeach
                                                <td>Rp{{ number_format($item->harga, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($item->total_harga, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Data Penjualan</h6>
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
            Highcharts.chart('grafik', {
                title: {
                    text: 'Grafik Laporan Penjualan'
                },
                subtitle: {
                    text: 'Data Penjualan'
                },
                xAxis: {
                    categories: [
                        @foreach ($penjualan as $item)
                            '{{ $item['bulan'] }}-{{ $item['tahun'] }}',
                        @endforeach
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Penjualan'
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
                    name: 'Data Penjualan',
                    data: [
                        @foreach ($penjualan as $item)
                            {{ $item['total_harga'] }},
                        @endforeach
                    ]
                }],
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
    @endpush
</x-app-layout>
