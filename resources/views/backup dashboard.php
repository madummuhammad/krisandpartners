@extends('member.main')
@section('title', 'Dashboard')
@php
use App\Models\Notification;
@endphp
<style>
	.bg-gold{
		background-color: #ffd700 !important;
	}
</style>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					@foreach($notification as $notification)
					<div class="alert alert-warning d-flex align-items-center fs-4" role="alert">
						<i class="fa-regular fa-bell fs-6 text-dark me-3"></i> {{$notification->message}}
					</div>
					@php
					Notification::where('competition_join_category_id',$notification->competition_join_category_id)->delete();
					@endphp
					@endforeach
					@if($competition)
					<a href="{{url('competition/join/')}}/{{$competition->id}}">
						<h1 class="text-dark">{{$competition->title}}</h1>
						<img style="width: 25%; height: auto;object-fit: cover; object-position: center;" src="{{ asset('storage/' . $competition->banner) }}" alt="">
					</a>
					@else
					<img style="width: 100%; height: 400px;object-fit: cover; object-position: center;" src="" alt="Tidak ada kompetisi">
					@endif
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="white-box">
				<h3 class="box-title mb-4">KOMPETISI ANDA</h3>
				<div class="row">
					<div class="col-4">
						<select class="form-control" id="kategoriSelect">
							<option>Pilih Kategori</option>
							@foreach($filterCategory as $filterCategory)
							<option>{{$filterCategory->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-4">
						<select class="form-control" id="urutanSelect">
							<option value="">Urut Berdasarkan</option>
							<option value="0">No</option>
							<option value="1">Nama Peserta</option>
							<option value="2">Username</option>
							<option value="3">Kategori</option>
							<option value="4">Tanggal</option>
						</select>
					</div>
					<div class="col-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
							</div>
							<input type="text" class="form-control border-left-0" id="searchDashboardCompetition">
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table text-nowrap" id="dashboardCompetition">
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