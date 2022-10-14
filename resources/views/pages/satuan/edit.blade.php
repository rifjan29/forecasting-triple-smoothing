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
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active" aria-current="page">Form Basics</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data Satuan</h6>
                            <a href="{{ route('satuan.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('satuan.update', $satuan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <form class="form-responsive p-3">
                                    <div class="form-group">
                                        <label for="satuan">Satuan</label>
                                        <input type="text" class="form-control" name="satuan" id="satuan"
                                            placeholder="Masukkan satuan" onkeyup="tes()" value="{{ $satuan->satuan }}"
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
    @endsection
    @push('js')
        <script>
            function tes() {
                var input = $('#satuan').val()
                var letters = !/^[A-Za-z]+$/;
                if (input == "" || input.length > 15 || !/^[a-zA-Z]*$/g.test(input)) {
                    $('#satuan').attr('class', 'form-control is-invalid');

                } else {
                    $('#satuan').attr('class', 'form-control');
                }
            }
        </script>
    @endpush
</x-app-layout>
