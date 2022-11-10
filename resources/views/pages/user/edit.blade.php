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
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data User</h6>
                            <a href="{{ route('user.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update', $users->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" placeholder="Masukkan Nama"
                                            value="{{ $users->name }}" onkeyup="tas()" required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="Masukkan Email"
                                            value="{{ $users->email }}" onkeyup="tes()" required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="password" placeholder="Masukkan Password">
                                        <div class="invalid-feedback">
                                            Harap isi dengan benar
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Konfirmasi Password</label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" id="password"
                                            placeholder="Masukkan Konfirmasi Password">
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
                if (input == "" ||
                    /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
                    .test(input)) {
                    $('#email').attr('class', 'form-control is-invalid');
                    $('#email').val("");

                } else {
                    $('#email').attr('class', 'form-control');
                }
            }
        </script>
    @endpush
</x-app-layout>
