  @extends('web.main')
  @section('content')
    {{session('success')}}
    <div class="ugf-bg">
      <div class="final-content">
        <div class="icon">
          <img src="{{asset('assets/web')}}/images/big-green-check.png" alt="">
        </div>
        <h2>{{$message['title']}}</h2>
        <p>{{$message['message']}}</p>
        <a href="{{url('login')}}" class="text-primary fw-bold">Kembali kehalaman login</a>
      </div>
    </div>

@endsection