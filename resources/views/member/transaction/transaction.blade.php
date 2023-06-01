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
		<div class="col-sm-9">
			<div class="white-box">
				<h3 class="box-title mb-4">TRANSAKSI ANDA</h3>
				<div class="row">
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
								<th class="border-top-0">No. Transaksi</th>
								<th class="border-top-0">Nama Kompetisi</th>
								<th class="border-top-0">Tanggal</th>
								<th class="border-top-0">Biaya</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transaction as $transaction)				
							<tr>
								<td>{{$loop->index+1}}</td>
								<td></td>
								<td>{{$transaction->competition->title}}</td>
								<td>{{explode(' ',$transaction->created_at)[0]}}</td>
								<td>Rp.{{$transaction->total}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection