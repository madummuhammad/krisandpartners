  @extends('web.main')
  @section('content')
    
    <div class="ugf-bg">
      <div class="final-content">
        <div class="icon">
          <img src="{{asset('assets/web')}}/images/big-green-check.png" alt="">
        </div>
        <h2>Pendaftaran Berhasil</h2>
        <p>Kami telah mengirimkan link verifikasi ke email anda <br> Silahkan buka email anda <b>({{session('email')}})</b> dan klik link verifikasi yang tertera</p>
      </div>
    </div>

@endsection