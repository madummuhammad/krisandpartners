@extends('member.main')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="white-box">
				<h3 class="box-title mb-4">RINGKASAN PEMBELIAN ANDA</h3>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0 pe-0 d-flex justify-content-between">
						<div>
							Kompetisi
						</div>
						<div class="text-end pe-1">:</div>
					</label>
					<div class="col-sm-5 ps-0">
						<div class="form-control px-0 py-0 border-0">{{$competition->competition->title}}</div>
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0 pe-0 d-flex justify-content-between">
						<div>
							Kategori
						</div>
						<div class="text-end pe-1">:</div>
					</label>
					<div class="col-sm-5 ps-0">
						@php
						$total=0;
						@endphp
						@foreach($competition->competition_join_category as $category)
						@php
						$total=$total+$category->price;
						@endphp
						<div class="form-control px-0 py-0 border-0">{{$category->categories->name}} (Rp. {{$category->price}}) @if($category->price==0) (Gratis) @endif</div>
						@endforeach
					</div>
				</div>
				<div class="form-group mb-0 row">
					<label for="waktu_aktif" class="col-sm-3 col-form-label py-0 pe-0 d-flex justify-content-between">
						<div>
							TOTAL
						</div>
						<div class="text-end pe-1">:</div>
					</label>
					<div class="col-sm-5 ps-0">
						<div class="form-control px-0 py-0 border-0">Rp. {{$total}}</div>
					</div>
				</div>
				<div class="d-flex justify-content-end">
					<a href="{{url('/competition/join')}}/{{$competition->competition_id}}" class="btn mt-4 btn-secondary me-3 text-white">Kembali</a>
					@if($competition->payment==null)
					<form action="{{ route('competition.transaction',$competition->id) }}" method="POST">
						@csrf
						<button class="btn-success btn text-white mt-4">Konfirmasi Pembayaran</button>
					</form>
					@else
					@if(env('APP_ENV')=='development')
					<a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/{{$competition->payment->midtrans_order_id}}" class="btn-success btn text-white mt-4">Konfirmasi Pembayaran</a>
					@else
					<a href="https://app.midtrans.com/snap/v2/vtweb/{{$competition->payment->midtrans_order_id}}" class="btn-success btn text-white mt-4">Konfirmasi Pembayaran</a>
					@endif
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection