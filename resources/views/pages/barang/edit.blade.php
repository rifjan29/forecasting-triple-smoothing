<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Barang</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Home</a></li>
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
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data Barang</h6>
                            <a href="{{ route('barang.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="nama">Nama Barang</label>
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Masukkan nama barang" onkeyup="tes()" value="{{ $barang->nama }}"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi nama barang
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_satuan">Satuan Barang</label>
                                        <select name="id_satuan" id="id_satuan" onchange="pilih()"
                                            class="form-control form-control @error('id_satuan') is-invalid @enderror">
                                            <option value="0">Pilih Satuan Barang</option>
                                            @foreach ($id_satuan as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('satuan', $barang->id_satuan) == $item->id) selected @endif>{{ $item->satuan }}
                                                </option>
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

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <a href="login.html" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
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
