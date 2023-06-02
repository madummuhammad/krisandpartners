<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Template</title>

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
    <link rel="icon" href="{{asset('assets/web')}}/images/favicon.png">
    <link rel="apple-touch-icon" href="{{asset('assets/web')}}/assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/web')}}/images/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/web')}}/images/icon-114x114.png">

  </head>
  <body>

    @yield('content');


    <div class="footer">
      <div class="social-links">
        <a href="#"><i class="lab la-facebook-f"></i></a>
        <a href="#"><i class="lab la-twitter"></i></a>
        <a href="#"><i class="lab la-linkedin-in"></i></a>
        <a href="#"><i class="lab la-instagram"></i></a>
      </div>
      <div class="copyright">
        <p>Copyright © 2023 Anfra. All Rights Reserved</p>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{asset('assets/web')}}/js/jquery.min.js"></script>
  <script src="{{asset('assets/web')}}/js/popper.min.js"></script>
  <script src="{{asset('assets/web')}}/js/bootstrap.min.js"></script>
  <script src="{{asset('assets/web')}}/js/custom.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript">
    $('#reload').click(function () {
      $.ajax({
        type: 'GET',
        url: 'reload-captcha',
        success: function (data) {
          $(".captcha .img").html(data.captcha);
        }
      });
    });
  </script>
</body>
</html>
