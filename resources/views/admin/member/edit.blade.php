           @extends('admin.main')
           @section('title','Edit Member')
           @section('content')
           <div class="container-fluid">
           	<div class="row">
           		<div class="col-sm-9">
           			<div class="white-box">
                        <form action="{{url('admin/member/edit')}}/{{$member->id}}" method="POST">
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
                                <input type="text" class="form-control" id="inputPassword" name="password" value="{{$member->password_text}}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1 row">
                            <label for="inputNote" class="col-sm-3 col-form-label">Note</label>
                            <div class="col-sm-5">
                                <textarea name="note" id="inputNote" cols="30" rows="5" class="form-control">{{ $member->note ?? '' }}</textarea>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <a href="{{ url('admin/member') }}" class="btn btn-light mb-2 px-5 me-2 mt-4">KEMBALI</a>
                                <button type="submit" class="btn btn-success text-white mb-2 px-5 me-2 mt-4">SIMPAN</button>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3 mt-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0" placeholder="Cari">
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                           <thead>
                              <tr>
                                 <th class="border-top-0">No</th>
                                 <th class="border-top-0">Judul Kompetisi</th>
                                 <th class="border-top-0">Tgl. Menang</th>
                                 <th class="border-top-0">Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                            @foreach($competition_join_categories as $value)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                             <td>{{$value->competition_join->competition->title}}</td>
                             <td>{{$value->win_date}}</td>
                             <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                   <a href="{{url('admin/competition/certificate/')}}/{{$value->certificate->id}}" class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
                               </div>
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