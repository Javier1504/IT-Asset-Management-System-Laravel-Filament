@component('mail::message')
# Permintaan Aset Pribadi

Halo **{{ $user->name_karyawan }}**,

{{ $messageText }}

@component('mail::button', ['url' => $url])
Akses ITAM
@endcomponent


Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
