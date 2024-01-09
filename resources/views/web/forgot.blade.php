  @extends('web.main')
  @section('content')
  <div class="ugf-wrapper">
    <div class="logo d-none d-md-block mt-0">
      <a href="{{url('/login')}}">
<!--         <h3 class="text-white">
          Kris and Partners
        </h3> -->
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
              <div class="navbar-brand">
                <div class="logo d-block d-md-none">
                  <a href="{{url('/login')}}">
                    <!-- Kris and Partners -->
                    <img src="{{asset('assets/web')}}/images/logo.png" class="img-fluid logo-white" alt="logo">
                    <img src="{{asset('assets/web')}}/images/logo-dark.png" class="img-fluid logo-black" alt="logo">
                  </a>
                </div>
              </div>
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
          <div class="mt-2 d-block d-md-none"> 
            @if($competition)           
            <img class="img-fluid" src="{{ asset('storage/' . $competition->banner) }}" alt="">
            @else
            <img class="img-fluid" src="" alt="">
            @endif
          </div>
          <style>
            .ufg-job-application-wrapper{
              max-width: 100%;
            }
          </style>
          <div class="ufg-job-application-wrapper pt-5 mt-5">
            <div class="form-steps active w-100">
              <h3 class="text-center">Lupa Password</h3>
              @if(session('error'))
              <div class="alert alert-warning" role="alert">
               {{session('error')}}
             </div>
             @endif
             @if(session('success'))
             <div class="alert alert-success" role="alert">
               {{session('success')}}
             </div>
             @endif
             <form action="{{ route('forgot-password') }}" method="POST" class="job-application-form">
              @csrf
              <div class="form-group">
                <input type="text" class="form-control w-100 @error('email') is-invalid @enderror" id="input-email" name="email" required>
                <label for="input-email">Email</label>
                @error('email')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}
              <div class="d-none d-md-flex mt-2 justify-content-between align-items-center">
                <button type="submit" class="btn">Kirim</button>
                <div class="py-3">
                  <p class="text-dark">Sudah ingat password? <a href="{{url('login')}}" class="text-primary fw-bold">Login</a></p>
                </div>
              </div>
              <div class="d-block d-md-none mt-2 justify-content-between align-items-center">
                <button type="submit" class="btn w-100">Kirim</button>
                <div class="py-3">
                  <p class="text-dark text-center">Sudah ingat password? <a href="{{url('login')}}" class="text-primary fw-bold">Login</a></p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

