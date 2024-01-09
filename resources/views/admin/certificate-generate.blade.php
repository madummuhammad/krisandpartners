@section('title', 'Sertifikat')
@extends('admin.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="white-box">
				<h3 class="box-title mb-4">SERTIFIKAT</h3>
				<form action="" method="POST">
					@csrf
					@method('post')
					<div class="form-group mb-3 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Nama Sertifikat</label>
						<div class="col-sm-5">
							<div class="d-flex align-items-center">
								<div class="pe-2">:</div>
								<input class="form-control py-0" name="name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="d-flex justify-content-start align-items-center">
								<a href="{{url()->previous()}}" class="btn btn-outline-secondary px-5 fw-bold me-3">Kembali</i></a>
								<button class="btn btn-outline-primary px-5 fw-bold me-3">Download <i class="fa-solid fa-file-arrow-down"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection