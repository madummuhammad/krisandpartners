@section('title', 'Edit User')
@extends('admin.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">EDIT USER</h3>
                <form action="{{ url('admin/user/update', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $user->username }}">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level" class="col-sm-3 col-form-label">Level</label>
                        <div class="col-sm-5">
                            <select class="form-control @error('level') is-invalid @enderror" id="level" name="level">
                                <option>Pilih Level</option>
                                <option value="superadmin" {{ $user->level == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-start">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-5">
                            <a href="{{ url('admin/user') }}" class="btn btn-secondary me-2 text-white">BATAL</a>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection