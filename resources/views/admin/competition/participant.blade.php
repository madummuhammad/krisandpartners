           @extends('admin.main')
           @section('title','Peserta')
           @section('content')
           <style>
              .bg-gold{
                 background-color: #ffd700 !important;
              }
           </style>
           <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="white-box">
                     <h3 class="box-title mb-4">Peserta</h3>
                     <div class="row">
                        <div class="col-8">
                           <div class="row">
                             <div class="col-4">
                               <select class="form-control" id="kategoriSelect">
                                 <option>Pilih Kategori</option>
                                 @foreach($category as $category)
                                 <option>{{$category->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-4">
                            <select class="form-control" id="usernameSelect">
                              <option>Pilih Username</option>
                              @foreach($member as $member)
                              <option>{{$member->username}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-4">
                         <select class="form-control" id="urutanSelect">
                          <option value="">Urut Berdasarkan</option>
                          <option value="0">No</option>
                          <option value="1">Nama Peserta</option>
                          <option value="2">Username</option>
                          <option value="3">Kategori</option>
                          <option value="4">Tanggal</option>
                       </select>
                    </div>
                 </div>
              </div>
              <div class="col-4">
               <div class="input-group mb-3">
                  <div class="input-group-prepend">
                     <span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                  </div>
                  <input type="text" class="form-control border-left-0" id="searchInput" placeholder="Cari...">
               </div>
            </div>
         </div>
         <div class="table-responsive">
          <table class="table text-nowrap" id="participant">
             <thead>
                <tr>
                   <th class="border-top-0">No</th>
                   <th class="border-top-0">No Transaksi</th>
                   <th class="border-top-0">Nama Peserta</th>
                   <th class="border-top-0">Username</th>
                   <th class="border-top-0">Kategori</th>
                   <th class="border-top-0">Tanggal</th>
                   <th class="border-top-0">Pengajuan</th>
                   <th class="border-top-0">Aksi</th>
                </tr>
             </thead>
             <tbody>
               @php
               $no=1;
               @endphp
               @foreach($participant as $member)
               @foreach($member->competition_join_category as $category)
               <tr class="@if($category->win_status==1) bg-gold @endif">
                 <td>{{$no++}}</td>
                 <td>{{$member->payment->payment_number}}</td>
                 <td>{{$member->member->name}}</td>
                 <td>{{$member->member->username}}</td>
                 <td>{{$category->categories->name}}</td>
                 <td>{{$member->join_date}}</td>
                 <td>
                  @if($category->categories->free==0)
                  @if($category->submision_status==0)
                  <span class="badge badge-warning">
                     Belum Diajukan
                  </span>
                  @endif
                  @if($category->submision_status==1)
                  <span class="badge badge-success">
                     Sudah Diajukan
                  </span>
                  @endif
                  @endif
               </td>
               <td>
                  @if($category->categories->free==0)
                 <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="{{url('admin/competition/participant/detail/')}}/{{$category->id}}" class="btn btn-secondary text-white"><i class="fa-regular fa-eye"></i></a>
                    @if($category->certificate)
                    <a href="{{url('admin/competition/certificate/')}}/{{$category->certificate->id}}" class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
                    @else
                    <a class="btn btn-secondary text-white"><i class="fa-solid fa-medal"></i></a>
                    @endif
                 </div>
                 @endif
              </td>
           </tr>
           @endforeach
           @endforeach
        </tbody>
     </table>
  </div>
</div>
</div>
</div>
</div>
@endsection