@if (session('status'))
{{-- alert berhasil --}}
{{-- <strong>{{ session('status') }}</strong> --}}
rediara->withStatus('berhaakwrma');
@endif

@if (session('error'))
{{-- alert gagal atau kesalahan --}}
{{-- <strong>{{ session('status') }}</strong> --}}

@endif



