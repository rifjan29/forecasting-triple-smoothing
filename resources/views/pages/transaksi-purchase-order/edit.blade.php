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
                <h1 class="h3 mb-0 text-gray-800">Purchase Order</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Transaksi</li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
                </ol>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data Purchase Order</h6>
                            <a href="{{ route('purchase-order.index') }}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-duotone fa-file"></i>
                                </span>
                                <span class="text">Lihat Semua Data</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <form class="form-responsive p-3" action="{{ route('purchase-order.update', $transaksi->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="id_barang">Nama Barang</label>
                                        <select name="id_barang" id="id_barang" onchange="pilih()"
                                            class="id_barang form-control @error('id_barang') is-invalid @enderror"
                                            required>
                                            <option value="0">Pilih Nama Barang</option>
                                            @foreach ($id_barang as $item)
                                                <option value="{{ $item->id . '-' . $item->nama }}"
                                                    @if (old('barang', $transaksi->id_barang) == $item->id) selected @endif>{{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_barang')
                                            <div class="invalid-feedback">
                                                Harap pilih satuan barang
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="month">Bulan</label>
                                        <input type="month" class="form-control @error('month') is-invalid @enderror"
                                            name="month" id="month" min="2020-02"
                                            value="{{ $transaksi->tahun . '-' . $transaksi->bulan }}" required>
                                        @error('month')
                                            <div class="invalid-feedback">
                                                Harap pilih bulan
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="qty">Qty</label>
                                        <input type="number" class="form-control @error('qty') is-invalid @enderror"
                                            name="qty" id="qty" placeholder="Masukkan qty" onkeyup="hitungTotal()"
                                            value="{{ $transaksi->qty }}" required>
                                        <div class="invalid-feedback">
                                            Harap isi dengan angka saja
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="harga">Harga</label>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                            name="harga" id="harga" placeholder="Masukkan harga"
                                            value="{{ $transaksi->harga }}" onkeyup="hitungTotal()" required>
                                        @error('harga')
                                            <div class="invalid-feedback">
                                                Harap diisi
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="total_harga">Total</label>
                                        <input type="number"
                                            class="form-control @error('total_harga') is-invalid @enderror"
                                            value="{{ $transaksi->total_harga }}" name="total_harga" id="total_harga"
                                            placeholder="Masukkan total_harga" readonly>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
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
            function hitungTotal() {
                var qty = parseInt($('#qty').val())
                var harga = parseInt($('#harga').val())
                var total = qty * harga
                $('#total_harga').val(total)
            }

            function tes() {
                var input = $('#qty').val()
                if (input == "" || !/^[0-9]*$/g.test(input)) {
                    $('#qty').attr('class', 'form-control is-invalid');
                    $('#qty').val("");

                } else {
                    $('#qty').attr('class', 'form-control');
                }
            }

            function tas() {
                var input = $('#harga').val()
                if (input == "" || !/^[0-9]*$/g.test(input)) {
                    $('#harga').attr('class', 'form-control is-invalid');
                    $('#harga').val("");

                } else {
                    $('#harga').attr('class', 'form-control');
                }
            }

            function tos() {
                var input = $('#total_harga').val()
                if (input == "" || !/^[0-9]*$/g.test(input)) {
                    $('#total_harga').attr('class', 'form-control is-invalid');
                    $('#total_harga').val("");

                } else {
                    $('#total_harga').attr('class', 'form-control');
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
