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
                    <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Data Purchase Order</h6>
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
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Alpha</label>
                                    <label>{{ $alpha }}</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Mape</label>
                                    <label>{{ $mape }}</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Peramalan {{ $get_periode }} periode pada {{ $periode }}</label>
                                    <label>Rp{{ number_format($forecast, 2, ',', '.') }}</label>
                                    <label></label>
                                </div>
                            </div>
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
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
        <script>
            function hapusModal(id) {
                // console.log(id);
                var url = "{{ url('/transaksi/purchase-order') }}/" + id;
                // console.log(url);
                $('#exampleModalCenter').modal('show');
                $('#delete_form').attr('action', url);
            }
        </script>
    @endpush
</x-app-layout>