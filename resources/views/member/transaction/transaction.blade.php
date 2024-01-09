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
		<div class="col-sm-10">
			<div class="white-box">
				<h3 class="box-title mb-4">TRANSAKSI ANDA</h3>
				<div class="row">
					<div class="col-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
							</div>
							<input type="text" class="form-control border-left-0" id="searchTransaction">
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table text-nowrap" id="transaction">
						<thead>
							<tr>
								<th class="border-top-0">No</th>
								<th class="border-top-0">No. Transaksi</th>
								<th class="border-top-0">Nama Kompetisi</th>
								<th class="border-top-0">Tanggal</th>
								<th class="border-top-0">Biaya</th>
								<th class="border-top-0">Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transaction as $transaction)				
							<tr>
								<td>{{$loop->index+1}}</td>
								<td>{{$transaction->payment->payment_number}}</td>
								<td>{{$transaction->competition->title}}</td>
								<td>{{explode(' ',$transaction->created_at)[0]}}</td>
								<td>Rp.{{$transaction->total}}</td>
								<td>
									@if($transaction->status=='paid')
									<div class="badge badge-success">
										{{$transaction->status}}
									</div>
									@endif
									@if($transaction->status=='unpaid')
									<div class="badge badge-danger">
										{{$transaction->status}}
									</div>
									@endif
									@if($transaction->status=='pending')
									<div class="badge badge-warning">
										{{$transaction->status}}
									</div>
									@endif
									@if($transaction->status=='failed')
									<div class="badge badge-danger">
										{{$transaction->status}}
									</div>
									@endif
								</td>
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