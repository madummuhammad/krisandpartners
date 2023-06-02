           @extends('admin.main')
           @section('title','Dashboard')
           @section('content')
           <div class="container-fluid">
           	<div class="row">
           		<div class="col-sm-9">
           			<div class="white-box">
           				<h3 class="box-title mb-4">MEMBERS</h3>
           				<div class="row">
           					<div class="col-8"></div>
           					<div class="col-4">
           						<div class="input-group mb-3">
           							<div class="input-group-prepend">
           								<span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
           							</div>
           							<input type="text" class="form-control border-left-0" id="searchMember">
           						</div>
           					</div>
           				</div>
           				<div class="table-responsive">
           					<table class="table text-nowrap" id="member-table">
           						<thead>
           							<tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Nama</th>
                                        <th class="border-top-0">Username</th>
                                        <th class="border-top-0">Tgl. Registrasi</th>
                                        <th class="border-top-0">Win</th>
                                        <th class="border-top-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->username }}</td>
                                        <td>{{ $member->register_date }}</td>
                                        <td>{{count($member->win)}}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                <a href="{{ url('admin/member/edit/' . $member->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-eye"></i></a>
                                                <button class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $member->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $member->id }}">Hapus Member</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus member ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.member.destroy', ['id' => $member->id]) }}" method="POST" style="display: inline">
                                                        @method('DELETE')
                                                        @csrf
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