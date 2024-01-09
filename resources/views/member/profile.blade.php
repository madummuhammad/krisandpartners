           @extends('member.main')
           @section('title','Profile')
           @section('content')
           <div class="container-fluid">
           	<div class="row">
           		<div class="col-sm-9">
           			<div class="white-box">
                    <h4 class="fw-bold text-center">PROFIL</h4>
                        <form action="{{url('profile')}}/{{$member->id}}" method="POST">
                            @csrf
                            @method('post')
                            <div class="form-group mb-1 row">
                                <label for="inputName" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" value="{{ old('name', $member->name ?? '') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label for="inputUsername" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="inputUsername" name="username" value="{{ old('username', $member->username ?? '') }}">
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label for="inputCertificateName" class="col-sm-3 col-form-label">Nama Sertifikat</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control @error('certificate_name') is-invalid @enderror" id="inputCertificateName" name="certificate_name" value="{{ old('certificate_name', $member->certificate_name ?? '') }}">
                                    @error('certificate_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label for="inputRegistrationDate" class="col-sm-3 col-form-label">Tgl. Registrasi</label>
                                <div class="col-sm-5 d-flex align-items-center">
                                    : {{ $member->register_date }}
                                </div>
                            </div>
                            <div class="form-group mb-1 row">
                                <label for="inputPhone" class="col-sm-3 col-form-label">No. Handphone</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" name="phone" value="{{ $member->phone }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                       {{ $message}}
                                   </div>
                                   @enderror
                               </div>
                           </div>
                           <div class="form-group mb-1 row">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{ $member->email}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-1 row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="inputPassword" name="password" value="{{$member->password_text}}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <a href="{{ url()->previous(); }}" class="btn btn-light mb-2 px-5 me-2 mt-4">KEMBALI</a>
                                <button type="submit" class="btn btn-success text-white mb-2 px-5 me-2 mt-4">SIMPAN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection