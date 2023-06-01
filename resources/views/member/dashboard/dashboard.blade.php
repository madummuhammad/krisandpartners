@extends('member.main')
@section('title', 'Dashboard')
<style>
	.bg-gold{
		background-color: #ffd700;
	}
</style>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<a href="{{url('competition/join/')}}/{{$competition->id}}">
						<img style="width: 100%; height: 400px;object-fit: cover; object-position: center;" src="{{ asset('storage/' . $competition->banner) }}" alt="">
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="white-box">
				<h3 class="box-title mb-4">KOMPETISI ANDA</h3>
				<div class="row">
					<div class="col-4">
						<select class="form-control" id="exampleFormControlSelect1">
							<option>Pilih Kategori</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					</div>
					<div class="col-4">
						<select class="form-control" id="exampleFormControlSelect1">
							<option>Urut Berdasarkan</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					</div>
					<div class="col-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
							</div>
							<input type="text" class="form-control border-left-0">
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table text-nowrap">
						<thead>
							<tr>
								<th class="border-top-0">ID</th>
								<th class="border-top-0">Judul Kompetisi</th>
								<th class="border-top-0">Kategori</th>
								<th class="border-top-0">Tanggal</th>
								<th class="border-top-0">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no=1 ?>
							@foreach($category as $value)
							@if($value->competition_join)							
							<tr class="@if($value->win_status==1) bg-gold @endif">
								<td>{{$no++}}</td>
								<td>{{$value->competition_join->competition->title}}</td>
								<td>{{$value->categories->name}}</td>
								<td>{{$value->competition_join->join_date}}</td>
								<td>
									<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
										@foreach($value->competition_join->competition_join_category as $id)
										@if($id->category_id==$value->categories->id)
										<a href="{{url('competition/detail')}}/{{$id->id}}" class="btn btn-secondary text-white"><i class="fa-regular fa-eye"></i></a>
										@if($value->win_status==1)
										<a target="_blank" href="{{url('certificate/')}}/{{$id->certificate->id}}" class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
										@else
										<a href="" class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
										@endif
										@endif
										@endforeach
									</div>
								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection