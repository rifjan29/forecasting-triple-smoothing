<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Barang</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">Barang</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Barang</h6>
                            <a href="{{ route('barang.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('barang.store') }}" method="POST">
                                @csrf
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="nama">Nama Barang</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Masukkan nama barang" onkeyup="tes()" required>
                                        <div class="invalid-feedback">
                                            Harap isi nama barang
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_satuan">Satuan Barang</label>
                                        <select name="id_satuan" id="id_satuan"
                                            class="id_satuan form-control @error('id_satuan') is-invalid @enderror"
                                            required>
                                            <option value="0">Pilih Satuan Barang</option>
                                            @foreach ($id_satuan as $item)
                                                <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_satuan')
                                            <div class="invalid-feedback">
                                                Harap pilih satuan barang
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
            <!--Row-->

        </div>
    @endsection
    @push('js')
        <script>
            function tes() {
                var input = $('#nama').val()
                if (input == "") {
                    $('#nama').attr('class', 'form-control is-invalid');
                    $('#nama').val("");

                } else {
                    $('#nama').attr('class', 'form-control');
                }
            }

            function pilih() {
                var input = $('#id_satuan').val()
                if (input == "0" || input == null) {
                    $('#id_satuan').attr('class', 'form-control is-invalid');
                    $('#id_satuan').val("");
                } else {
                    $('#id_satuan').attr('class', 'form-control');
                }
            }
        </script>
    @endpush
</x-app-layout>
