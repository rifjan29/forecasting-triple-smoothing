@props(['status'])

@if ($status)
    {{-- <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div> --}}
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
        <strong>{{ $status }}</strong>
    </div>
@endif
