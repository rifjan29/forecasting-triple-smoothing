<x-app-layout>
    @push('css')
        <style>
            .select2-container--default .select2-selection--single {
                border: 1px solid #ced4da;
                height: calc(2.25rem + 2px);
                padding: .375rem .75rem;
            }
        </style>
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
                            <form class="form-responsive p-3" action="{{ route('report-penjualan.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="id_barang">Nama Barang</label>
                                        <select name="id_barang" id="id_barang"
                                            class="id_barang form-control py-3 @error('id_barang') is-invalid @enderror"
                                            required>
                                            <option value="0">Pilih Nama Barang</option>
                                            @foreach ($id_barang as $item)
                                                <option value="{{ $item->id . '-' . $item->nama }}">{{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_barang')
                                            <div class="invalid-feedback">
                                                Harap pilih barang
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary form-group col-md-12">Simpan</button>
                                </div>
                            </form>
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
    @endpush
</x-app-layout>
