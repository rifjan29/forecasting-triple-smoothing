<x-app-layout>
    @push('css')
        <style></style>
    @endpush
    @section('content')
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">User</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data User</h6>
                            <a href="{{ route('user.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" placeholder="Masukkan Nama" onkeyup="tas()"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="Masukkan Email" onkeyup="tes()"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="password" placeholder="Masukkan Password" onkeyup="tos()"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Konfirmasi Password</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" id="password" placeholder="Masukkan Konfirmasi Password" onkeyup="tis()"
                                            required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
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
            function tas() {
                var input = $('#name').val()
                if (input == "") {
                    $('#name').attr('class', 'form-control is-invalid');
                    $('#name').val("");

                } else {
                    $('#name').attr('class', 'form-control');
                }
            }
            function tes() {
                var input = $('#email').val()
                if (input == "" ||  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(input)) {
                    $('#email').attr('class', 'form-control is-invalid');
                    $('#email').val("");

                } else {
                    $('#email').attr('class', 'form-control');
                }
            }
            function tos() {
                var input = $('#password').val()
                if (input == "") {
                    $('#password').attr('class', 'form-control is-invalid');
                    $('#password').val("");

                } else {
                    $('#password').attr('class', 'form-control');
                }
            }
            function tis() {
                var input = $('input[name="password_confirmation"]').val()
                if (input == "") {
                    $('input[name="password_confirmation"]').attr('class', 'form-control is-invalid');
                    $('input[name="password_confirmation"]').val("");

                } else {
                    $('input[name="password_confirmation"]').attr('class', 'form-control');
                }
            }
        </script>
    @endpush
</x-app-layout>
