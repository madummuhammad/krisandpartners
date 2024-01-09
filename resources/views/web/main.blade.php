<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Kris & Partners</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/web')}}/css/bootstrap.min.css">

    <!-- External Css -->
    <link rel="stylesheet" href="{{asset('assets/web')}}/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{asset('assets/web')}}/css/owl.carousel.min.css" />

    <!-- Custom Css --> 
    <link rel="stylesheet" type="text/css" href="{{asset('assets/web')}}/css/main.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/web')}}/css/job-1.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <!-- <link rel="icon" href="{{asset('assets/web')}}/images/favicon.png"> -->
    <!-- <link rel="apple-touch-icon" href="{{asset('assets/web')}}/assets/images/apple-touch-icon.png"> -->
<!--     <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/web')}}/images/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/web')}}/images/icon-114x114.png"> -->

  </head>
  <body>

    @yield('content');
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{asset('assets/web')}}/js/jquery.min.js"></script>
  <script src="{{asset('assets/web')}}/js/popper.min.js"></script>
  <script src="{{asset('assets/web')}}/js/bootstrap.min.js"></script>
  <script src="{{asset('assets/web')}}/js/custom.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
</body>
</html>
