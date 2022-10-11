<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Satuan</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('satuan.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">Satuan</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Satuan</h6>
                            <a href="{{ route('satuan.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('satuan.store') }}" method="POST">
                                @csrf
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="satuan">Satuan</label>
                                        <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                            name="satuan" id="satuan" placeholder="Masukkan satuan" onkeyup="tes()"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan huruf saja
                                        </div>
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
                var input = $('#satuan').val()
                if (input == "" || input.length > 15 || !/^[a-zA-Z]*$/g.test(input)) {
                    $('#satuan').attr('class', 'form-control is-invalid');
                    $('#satuan').val("");

                } else {
                    $('#satuan').attr('class', 'form-control');
                }
            }
        </script>
    @endpush
</x-app-layout>
