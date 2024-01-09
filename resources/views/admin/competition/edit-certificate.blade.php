@section('title', 'Sertifikat')
@extends('admin.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="white-box">
				<!-- <h3 class="box-title mb-4">KOMPETISI ANDA</h3> -->
<!-- 				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">No. Sertifikat</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$certificate->no_certificate}}</div>
					</div>
				</div> -->
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Nama Kompetisi</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$certificate->competition_join_category->competition_join->competition->title}}</div>
					</div>
				</div>
				<form action="" method="POST">
					@method('post')
					@csrf
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Nama Sertifikat</label>
						<div class="col-sm-5">
							<input class="form-control py-0" name="name" value="{{$certificate->competition_join_category->certificate->name}}">
						</div>
					</div>
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Nama Peserta</label>
						<div class="col-sm-5">
							<div class="form-control py-0 border-0">: {{$certificate->competition_join_category->member->name}}</div>
						</div>
					</div>
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Username</label>
						<div class="col-sm-5">
							<div class="form-control py-0 border-0">: {{$certificate->competition_join_category->member->username}}</div>
						</div>
					</div>
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Kategori</label>
						<div class="col-sm-5">
							<div class="form-control py-0 border-0">: {{$certificate->competition_join_category->categories->name}}</div>
						</div>
					</div>
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Tanggal Menang</label>
						<div class="col-sm-5">
							<div class="form-control py-0 border-0">{{$certificate->competition_join_category->win_date}}</div>
						</div>
					</div>
					<input type="submit" id="submit" hidden>
				</form>
				<div class="row">
					<div class="col-sm-12">
						<div class="d-flex justify-content-start align-items-center">
							<form action="{{url('admin/competition/certificate/download/')}}/{{$certificate->id}}" method="POST">
								@csrf
								@method('post')
								<button class="btn btn-outline-primary px-5 fw-bold me-3">Download <i class="fa-solid fa-file-arrow-down"></i></button>
							</form>
							<a href="{{url()->previous()}}" class="btn btn-outline-secondary px-5 fw-bold me-3">Kembali</i></a>
							<label for="submit" class="d-block btn btn-success text-white px-5 fw-bold mb-0">Simpan</i></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection