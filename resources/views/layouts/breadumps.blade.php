@if (Session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
        <strong>{{ Session('status') }}</strong>
    </div>
@endif

@if (Session('sukses'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
        <strong>{{ Session('sukses') }}</strong>
    </div>
@endif

@if (Session('warning'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
        <strong>{{ Session('warning') }}</strong>
    </div>
@endif

@if (Session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h6><i class="fas fa-ban"></i><b> Gagal!</b></h6>
        <strong>{{ Session('error') }}</strong>
    </div>
@endif
