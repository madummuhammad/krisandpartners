<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords"content="">
	<meta name="description"content="">
	<meta name="robots" content="noindex,nofollow">
	<title>Kris and Partners</title>
	<!-- <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" /> -->
	<!-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/admin')}}/plugins/images/favicon.png"> -->
	<link href="{{asset('assets/admin')}}/plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('assets/admin')}}/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
	<link href="{{asset('assets/admin')}}/css/style.css" rel="stylesheet">
	<link href="{{asset('assets/admin')}}/css/style.min.css" rel="stylesheet">
</head>

<body>
	<div class="page-wrapper d-flex align-items-center" style="height:100vh;">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-12">
					<form method="POST" action="{{url('admin/login')}}">
						@csrf		
						<div class="card">
							<div class="card-body">
								<div class="d-flex justify-content-center flex-column align-items-center">
									<img class="logo" src="<asdf" alt="">
										<h3 class="text-center">Silahkan Admin Login</h3>
									</div>
									<div class="mb-3">
										<input type="text"  value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username">
										@error('username')
										<div class="invalid-feedback">
											<span class="text-danger">{{ $message }}</span>
										</div>
										@enderror
									</div>
									<div class="mb-3">
										<input type="password"  value="" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
										@error('password')
										<div class="invalid-feedback">
											<span class="text-danger">{{ $message }}</span>
										</div>
										@enderror
									</div>
									{!! NoCaptcha::renderJs() !!}
									{!! NoCaptcha::display() !!}
									<div class="d-flex justify-content-center">
										<button class="btn btn-primary">Login</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
<script src="{{asset('assets/admin')}}/plugins/bower_components/chartist/dist/chartist.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="{{asset('assets/admin')}}/js/pages/dashboards/dashboard1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>