@component('mail::message')
# Verifikasi Email

Terima kasih telah mendaftar di aplikasi kami. Silakan klik tombol di bawah ini untuk memverifikasi email Anda:

@component('mail::button', ['url' => route('verification.verify', ['id' => $member->id, 'hash' => $member->token])])
Verifikasi Email
@endcomponent

Terima kasih,<br>
Kris and Partners
@endcomponent
