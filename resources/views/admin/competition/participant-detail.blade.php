@section('title', 'Dashboard')
@extends('admin.main')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="white-box">
				<!-- <h3 class="box-title mb-4">KOMPETISI ANDA</h3> -->
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Nama Peserta</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$competition->member->name}}</div>
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Username</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$competition->member->username}}</div>
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Kategori</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$competition->categories->name}}</div>
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Tanggal</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">: {{$competition->competition_join->join_date}}</div>
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Deskripsi</label>
					<div class="col-sm-5">
						<div class="form-control py-0 border-0">
							@php echo $competition->description @endphp
							@if($competition->submision_status==0) <span class="badge badge-warning">Belum Diajukan</span> @endif</div>
					</div>
				</div>
				<div class="row">
					@if($competition->submision_status==1)
					<div class="col-sm-6">
						<div class="card shadow p-0">
							<div class="card-body p-0">
								<img style="width:100%;height:300px" src="{{$competition->image}}" alt="">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card shadow p-0">
							<div class="card-body p-0">
								<video controls width="100%" height="300">
									<!-- Sumber video yang akan dimainkan -->
									<source src="{{$competition->url}}" type="video/mp4">
										Maaf, browser Anda tidak mendukung pemutaran video.
									</video>
								</div>
							</div>
						</div>
<!-- 						<div class="col-sm-12">
							<div class="d-flex justify-content-start">
								<a target="_blank" href="{{$competition->image}}" class="btn btn-outline-primary px-3 fw-bold">Download <i class="fa-solid fa-file-arrow-down"></i></a>
							</div>
						</div> -->
						@endif
						<div class="col-sm-12">
							<div class="d-flex justify-content-end">
								<a href="{{url()->previous()}}" class="btn btn-outline-success px-3 me-2 fw-bold mt-5">Kembali</a>
								@if($competition->submision_status==1)
								@if($competition->win_status==0)
								<form action="{{url('admin/competition/participant/detail/')}}/{{$competition->id}}" method="POST">
									@csrf
									@method('post')
									<input type="text" name="status" value="{{$competition->win_status}}" hidden>
									<button class="btn btn-outline-warning px-3 fw-bold mt-5">Tetapkan Pemenang</button>
								</form>
								@endif
								@if($competition->win_status==1)
								<form action="{{url('admin/competition/participant/detail/')}}/{{$competition->id}}" method="POST">
									@csrf
									@method('post')
									<input type="text" name="status" value="{{$competition->win_status}}" hidden>
									<button class="btn btn-outline-danger px-3 fw-bold mt-5">Batalkan Pemenang</button>
								</form>

								@endif
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection