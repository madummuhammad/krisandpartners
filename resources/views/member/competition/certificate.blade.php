<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Certificate</title>
</head>
<style>
	@page { 
		margin-left: 0px; 
		margin-top: 0px; 
		margin-right: 0px; 
		margin-bottom: 0px; 
	}
	body{
		font-family: "Inter", sans-serif;
		font-size: 9px;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		background-image: url({{public_path('storage/'.$settings->certificate)}});
	}

	.body{
		padding-left: 7%;
		margin-top: 36%;
	}
	h1{
		text-transform: uppercase;
		font-size: 50px;
		color: #DAA53B;
		text-align: center;
	}
</style>
<body style="">
	<div class="body" style="width:100%">
		<h1>{{$certificate->name}}</h1>
	</div>
</body>
</html>