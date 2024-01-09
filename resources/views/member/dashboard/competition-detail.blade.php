@section('title', 'Detail Kompetisi')
@extends('member.main')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="white-box">
				<form action="{{url('competition/detail/')}}/{{$competition->id}}" method="POST" enctype="multipart/form-data">
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
					@if($competition->submision_status==1)
					<div class="form-group mb-0 row">
						<label for="waktu_aktif" class="col-sm-3 col-form-label py-0">Deskripsi</label>
						<div class="col-sm-5">
							<div class="form-control py-0 border-0">@php echo $competition->description @endphp</div>
						</div>
					</div>
					@endif
					@if($competition->submision_status==0)
					<div class="form-group row">
						<label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
						<div class="col-sm-9">
							<textarea class="form-control @error('description') is-invalid @enderror" id="summernote" name="description" rows="10">{{ old('description') }}</textarea>
							@error('description')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="image" class="col-sm-3 col-form-label">Upload Foto <br>Max. 3mb (jpg)</label>
						<div class="col-sm-5">
							<div class="w-25">
								<label for="input_banner" style="cursor:pointer">
									<img class="img-fluid" id="banner_image" src="{{ asset('assets/admin/images/browse.png') }}" alt="">
								</label>
							</div>
							<input type="file" id="input_banner" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg, .jpeg" hidden>

							@error('image')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="judul" class="col-sm-3 col-form-label">Video</label>
						<div class="col-sm-9">
							<!-- 			<input type="file" class="form-control @error('url') is-invalid @enderror" id="judul" name="url" accept="video/mp4" value="{{ old('url') }}"> -->
							<button id="browseFile" type="button" class="btn btn-primary">Pilih File</button>
							<input type="text" name="url" value="" id="value_video" hidden>
							<div class="progress mt-3" style="height: 25px">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%">0% </div></div>
								<span id="status_upload" class="text-success fw-bold"></span>
								@error('url')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						@endif
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
											<source src="{{$competition->url}}" type="video/mp4">
												Maaf, browser Anda tidak mendukung pemutaran video.
											</video>
										</div>
									</div>
								</div>
								@endif
								<div class="col-sm-12">
									<div class="d-flex justify-content-end">
										@if($competition->submision_status==0)
										@csrf
										@method('patch')
										<button class="btn btn-primary mr-2 px-3 fw-bold mt-5">Ajukan</button>
										@endif
										<a href="{{url()->previous()}}" class="btn btn-outline-secondary px-5 me-2 fw-bold mt-5">Kembali</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
		<script>
			$(document).ready(function(){
				let browseFile = $('#browseFile');
				let resumable = new Resumable({
					target: '{{ route('competition.upload') }}',
					query: {
						_token: '{{ csrf_token() }}',
						id:'{{request()->segment(3)}}'
					},
					fileType: ['mp4'],
					headers: {
						'Accept': 'application/json'
					},
					testChunks: false,
					throttleProgressCallbacks: 1,
				});

				resumable.assignBrowse(browseFile[0]);

				resumable.on('fileAdded', function(file) {
					showProgress();
					resumable.upload()
				});

				resumable.on('fileProgress', function(file) {
					updateProgress(Math.floor(file.progress() * 100));
				});

				resumable.on('fileSuccess', function(file,
					response) {
					response = JSON.parse(response)
					$("#status_upload").html('Video berhasil di unggah');
					$('#value_video').val(response.path);
					$('.card-footer').show();
					console.log(response.path)
				});

				resumable.on('fileError', function(file, response) {
					console.log(file)
					console.log(response)
					alert('file uploading error.')
				});


				let progress = $('.progress');

				function showProgress() {
					progress.find('.progress-bar').css('width', '0%');
					progress.find('.progress-bar').html('0%');
					progress.find('.progress-bar').removeClass('bg-success');
					progress.show();
				}

				function updateProgress(value) {
					progress.find('.progress-bar').css('width', `${value}%`)
					progress.find('.progress-bar').html(`${value}%`)
				}

				function hideProgress() {
					progress.hide();
				}
			})
		</script>
		@endsection