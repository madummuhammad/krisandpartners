  @extends('web.main')
  @section('content')
  <div class="ugf-wrapper">
    <div class="logo">
      <a href="../index.html">
        <img src="{{asset('assets/web')}}/images/logo.png" class="img-fluid logo-white" alt="logo">
        <img src="{{asset('assets/web')}}/images/logo-dark.png" class="img-fluid logo-black" alt="logo">
      </a>
    </div>
    <div class="ugf-content-block">
      @if($competition)
      <img style="width: 100%; height: 100%;object-fit: cover; object-position: center;" src="{{ asset('storage/' . $competition->banner) }}" alt="">
      @else
      <img style="width: 100%; height: 100%;object-fit: cover; object-position: center;" src="" alt="">
      @endif
      <div class="content-block">
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-5 offset-lg-7 p-sm-0">
          <nav class="navbar navbar-expand-lg navbar-light bg-white px-0">
            <div class="container-fluid px-0 pt-3">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                  <li class="nav-item px-4">
                    <a class="nav-link fw-bold active fs-4" aria-current="page" href="{{url('/')}}">HOME</a>
                  </li>
                  <li class="nav-item px-4">
                    <a class="nav-link fw-bold fs-4" href="{{url('term_condition')}}">TERMS & CONDITION</a>
                  </li>
                  <li class="nav-item px-4">
                    <a href="{{url('contact_us')}}" class="nav-link fw-bold fs-4" href="#">CONTACT US</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          <div class="ufg-job-application-wrapper pt-5 mt-5">
            <div class="form-steps active">
              <h3 class="text-center">Login</h3>
              @if(session('error'))
              <div class="alert alert-warning" role="alert">
               {{session('error')}}
             </div>
             @endif
             <form action="{{ route('login') }}" method="POST" class="job-application-form">
              @csrf
              <div class="form-group">
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="input-username" name="username" required>
                <label for="input-username">Username</label>
                @error('username')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <div class="form-group">
                <input type="password" class="form-control  @error('password') is-invalid @enderror" id="input-password" name="password" required>
                <label for="input-password">Password</label>
                @error('password')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}
              <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn">Login</button>
                <div class="py-3">
                  <p class="text-dark">Belum punya akun? <a href="{{url('register')}}" class="text-primary fw-bold">Register</a></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

