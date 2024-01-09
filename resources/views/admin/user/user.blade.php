           @extends('admin.main')
           @section('title','Dashboard')
           @section('content')
           <div class="container-fluid">
            <div class="row">
                <div class="col-sm-9">
                    <div class="white-box">
                        <h3 class="box-title mb-4">USERS</h3>
                        @if (Auth::user()->level === 'superadmin')
                        <a href="{{url('admin/user/add')}}" class="btn btn-success mb-2 text-white">Tambah User</a>
                        @endif
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Email</th>
                                        <th class="border-top-0">Username</th>
                                        <th class="border-top-0">Level</th>
                                        <th class="border-top-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->level }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                @if ($user->level !== 'superadmin' && auth()->user()->level=='superadmin')
                                                <a href="{{ url('admin/user/edit', $user->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                                @endif
                                                @if(auth()->user()->id==$user->id)
                                                <a href="{{ url('admin/user/edit', $user->id) }}" class="btn btn-secondary text-white"><i class="fa-regular fa-pen-to-square"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Hapus User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus user ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection