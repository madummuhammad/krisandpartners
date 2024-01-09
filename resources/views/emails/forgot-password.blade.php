@component('mail::message')
# Forgot Password

Berikut adalah password anda:

{{$member->password_text}}

Terima kasih,<br>
Kris and Partners
@endcomponent
