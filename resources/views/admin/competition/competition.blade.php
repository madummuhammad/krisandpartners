@extends('admin.main')
@section('title', 'Dashboard')
@section('content')
@php
use Carbon\Carbon;
@endphp
@php
$currentDateTime = Carbon::now();
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">KOMPETISI</h3>
                <a href="{{ url('admin/competition/add') }}" class="btn btn-primary mb-2">Tambah Kompetisi</a>
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">No</th>
                                <th class="border-top-0">Judul Kompetisi</th>
                                <th class="border-top-0">Tanggal</th>
                                <th class="border-top-0">Peserta</th>
                                <th class="border-top-0">Pendapatan</th>
                                <th class="border-top-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;
                            @endphp
                            @foreach ($competitions as $competition)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $competition->title }}</td>
                                @if($currentDateTime<=$competition->to->format('Y-m-d H:i:s'))
                                <td>{{ $competition->from->format('d-m-Y') }} - {{ $competition->to->format('d-m-Y') }}</td>
                                @else
                                <td>Berkahir</td>
                                @endif
                                <td>{{count($competition->competition_join)}}</td>
                                <td>
                                    @php
                                    $total=0;
                                    @endphp
                                    @foreach($competition->competition_join as $sum)
                                    @php
                                    $total=$total+$sum->total
                                    @endphp
                                    @endforeach
                                    Rp.{{$total}}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a href="{{ url('admin/competition/view/'.$competition->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-eye"></i></a>
                                        <a href="{{ url('admin/competition/edit/'.$competition->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{ url('admin/competition/participant/'.$competition->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-user"></i></a>
                                        <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $competition->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Hapus -->
                            <div class="modal fade" id="deleteModal{{ $competition->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $competition->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $competition->id }}">Hapus Kompetisi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin menghapus kompetisi ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.competition.delete', $competition->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection