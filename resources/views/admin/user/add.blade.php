@extends('admin.main')
@section('title', 'Tambah User')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <div class="white-box">
                    <h3 class="box-title mb-4">TAMBAH USER</h3>
                    <form action="{{ route('admin.user.add') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="level" class="col-sm-3 col-form-label">Level</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="level" name="level">
                                    <option value="">Pilih Level</option>
                                    <option value="superadmin" {{ old('level') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                    <option value="admin" {{ old('level') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('level')
                                    <div class="text-danger">{{ $message }}</div>
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