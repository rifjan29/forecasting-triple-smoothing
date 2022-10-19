<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Transaksi</li>
                    <li class="breadcrumb-item active" aria-current="page">Profit</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
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
                                            <th>No.</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Total Penjualan</th>
                                            <th>Total Purchase Order</th>
                                            <th>Total Profit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profit as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                @php
                                                    $satuan = \App\Models\Satuan::select('satuan')
                                                        ->where('id', $item->id_satuan)
                                                        ->get();
                                                @endphp
                                                @foreach ($satuan as $itemsatuan)
                                                    <td>{{ $itemsatuan->satuan }}</td>
                                                @endforeach
                                                <td>Rp {{ number_format($item->total_penjualan, 2, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->total_pembelian, 2, ',', '.') }}</td>
                                                <td>Rp
                                                    {{ number_format($item->total_keuntungan, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div>
                                                            <a href="{{ route('profit.show', $item->id) }}"
                                                                class="btn btn-info btn-sm mr-2" title="Detail"
                                                                data-toggle="tooltip">
                                                                <i class="fas fa-info-circle"></i>
                                                                <span class="align-middle"></span>
                                                            </a>
                                                        </div>
                                                    </div>
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
