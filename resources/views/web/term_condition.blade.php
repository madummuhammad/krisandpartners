  @extends('web.main')
  @section('content')
  <div class="ugf-wrapper">     
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white shadow">
      <div class="container pt-3">
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
        <div class="collapse navbar-collapse d-md-flex justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item px-4">
              <a class="nav-link fw-bold fs-4" aria-current="page" href="{{url('/')}}">HOME</a>
            </li>
            <li class="nav-item px-4">
              <a class="nav-link fw-bold fs-4 active" href="{{url('term_condition')}}">TERMS & CONDITION</a>
            </li>
            <li class="nav-item px-4">
              <a href="{{url('contact_us')}}" class="nav-link fw-bold fs-4" href="#">CONTACT US</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container pt-5 mt-5">
      <div class="pt-5 d-block d-md-none" style="margin-top:50px">
        <?php echo $term_condition->term_condition ?>
      </div>
      <div class="pt-5 d-none d-md-block">
        <?php echo $term_condition->term_condition ?>
      </div>
    </div>
<!--     <div class="ufg-job-application-wrapperbg-dark w-100">
</div> -->
<!--     <div class="footer text-dark">
      <div class="social-links text-dark">
        <a href="#"><i class="lab text-dark la-facebook-f"></i></a>
        <a href="#"><i class="lab text-dark la-twitter"></i></a>
        <a href="#"><i class="lab text-dark la-linkedin-in"></i></a>
        <a href="#"><i class="lab text-dark la-instagram"></i></a>
      </div>
      <div class="copyright text-dark">
        <p class="text-dark">Copyright © 2023 Anfra. All Rights Reserved</p>
      </div>
    </div> -->
    @endsection

