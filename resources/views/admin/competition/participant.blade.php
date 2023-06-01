           @extends('admin.main')
           @section('title','Peserta')
           @section('content')
           <style>
               .bg-gold{
                background-color: #ffd700;
               }
           </style>
           <div class="container-fluid">
           	<div class="row">
           		<div class="col-sm-12">
           			<div class="white-box">
           				<h3 class="box-title mb-4">Peserta</h3>
           				<div class="row">
           					<div class="col-8">
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
           									<option>Pilih Username</option>
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
           						</div>
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
           								<th class="border-top-0">No</th>
           								<th class="border-top-0">Nama Peserta</th>
           								<th class="border-top-0">Username</th>
           								<th class="border-top-0">Kategori</th>
           								<th class="border-top-0">Tanggal</th>
           								<th class="border-top-0">Aksi</th>
           							</tr>
           						</thead>
           						<tbody>
                                    @foreach($participant as $member)
                                    @foreach($member->competition_join_category as $category)
           							<tr class="@if($category->win_status==1) bg-gold @endif">
           								<td>{{$loop->index+1}}</td>
           								<td>{{$member->member->name}}</td>
                                        <td>{{$member->member->username}}</td>
           								<td>{{$category->categories->name}}</td>
           								<td>{{$member->join_date}}</td>
           								<td>
           									<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
           										<a href="{{url('admin/competition/participant/detail/')}}/{{$category->id}}" class="btn btn-secondary text-white"><i class="fa-regular fa-eye"></i></a>
           										<a href="{{url('admin/competition/certificate/')}}/{{$category->certificate->id}}" class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
           									</div>
           								</td>
           							</tr>
                                    @endforeach
                                    @endforeach
           						</tbody>
           					</table>
           				</div>
           			</div>
           		</div>
           	</div>
           </div>
           @endsection