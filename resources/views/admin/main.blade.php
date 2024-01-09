<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"content="">
    <meta name="description"content="">
    <meta name="robots" content="noindex,nofollow">
    <title>Krisn and Partners</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/admin')}}/plugins/images/favicon.png"> -->
    <link href="{{asset('assets/admin')}}/plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/admin')}}/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <link href="{{asset('assets/admin')}}/css/style.css" rel="stylesheet">
    <link href="{{asset('assets/admin')}}/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin6">
                <a class="navbar-brand text-dark text-center" href="{{url('/admin')}}">
                    <span class="logo-text">
                        Kris & Partners
                    </span>
                </a>
                <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li>
                        <form action="{{url('admin/logout')}}" method="POST">
                            @csrf                          
                            <button class="btn bg-transparent text-white" href="#">
                            LOGOUT</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar" data-sidebarbg="skin6">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/competition')}}"
                        aria-expanded="false">
                        <i class="fa-solid fa-trophy"></i>
                        <span class="hide-menu">Kompetisi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/member')}}"
                    aria-expanded="false">
                    <i class="fa-solid fa-users"></i>
                    <span class="hide-menu">Member</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/settings')}}"
                aria-expanded="false">
                <i class="fa-solid fa-gear"></i>
                <span class="hide-menu">Settings</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/user')}}"
            aria-expanded="false">
            <i class="fa-regular fa-user"></i>
            <span class="hide-menu">User</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a href="{{url('admin/certificate')}}" class="sidebar-link waves-effect waves-dark sidebar-link" href="map-google.html"
        aria-expanded="false">
        <i class="fa-solid fa-certificate"></i>
        <span class="hide-menu">Sertifikat</span>
    </a>
</li>
</ul>
</nav>
</div>
</aside>
<div class="page-wrapper">
    @yield('content')
    <footer class="footer text-center"> 2021 © Kris And Partners
    </footer>
</div>
</div>
<script src="{{asset('assets/admin')}}/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{asset('assets/admin')}}/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets/admin')}}/js/app-style-switcher.js"></script>
<script src="{{asset('assets/admin')}}/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="{{asset('assets/admin')}}/js/waves.js"></script>
<script src="{{asset('assets/admin')}}/js/sidebarmenu.js"></script>
<script src="{{asset('assets/admin')}}/js/custom.js"></script>
<script src="{{asset('assets/admin')}}/js/filtering.js"></script>
<script src="{{asset('assets/admin')}}/plugins/bower_components/chartist/dist/chartist.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="{{asset('assets/admin')}}/js/pages/dashboards/dashboard1.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote(
            {height: 200}
            );

        $('#input_banner').change(function(e) {
            $(".preloader").removeAttr('style');
            var reader = new FileReader();
            reader.onload = function(e) {
                $(".preloader").css('display','none');
                document.querySelector("#banner_image").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#selectAll').click(function() {
            if ($(this).is(':checked')) {
                $('.category-checkbox').prop('checked', true);
                var all_price=$('.all-prices-category').val();
                $('.prices-category').val(all_price);
            } else {
                $('.category-checkbox').prop('checked', false);
            }
            $('.all-prices-category').on('keyup',function(){
                var selectAll=$('#selectAll').is(':checked');
                if(selectAll){
                    var price=$(this).val();
                    $('.prices-category').val(price);
                }
            })
        });

        function create_all_price(price){
        }


        $('#btnDelete').click(function(e) {
            if ($('.category-checkbox:checked').length === 0) {
                e.preventDefault();
            }
        });

        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-danger',
            cancelClass: 'btn-inverse',
            locale: {
                format: 'D/MM/YYYY'
            }
        });
    });

</script>
<script>
</script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</body>

</html>