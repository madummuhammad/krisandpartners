@extends('admin.main')
@section('title','Settings')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">SETTINGS</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="banner" class="col-sm-3 col-form-label">Upload Sertifikat (.jpg)</label>
                        <div class="col-sm-5">
                            <div class="w-50">
                                @if($settings->certificate)
                                <label for="input_banner" style="cursor:pointer">
                                    <img class="img-fluid" id="banner_image"
                                    src="{{ asset('storage/' . $settings->certificate) }}" alt="">
                                </label>
                                @else
                                <label for="input_banner" style="cursor:pointer">
                                    <img class="img-fluid" id="banner_image"
                                    src="{{ asset('assets/admin/images/browse.png') }}" alt="">
                                </label>
                                @endif
                            </div>
                            <input type="file" id="input_banner"
                            class="form-control @error('banner') is-invalid @enderror" name="banner" hidden>
                            @error('banner')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Email Utama</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputPassword" name="email" value="{{$settings->email}}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-5">
                            <button class="btn btn-success text-white">Kirim Perubahan</button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('admin.category.delete') }}" method="POST" id="deleteForm">
                    <div class="row">
                        <div class="col-sm-8">
                            <button id="btnDelete" class="btn btn-light  mb-2 me-2" >
                              Hapus Kategori
                          </button>
                          <a href="{{url('admin/competition/add')}}" class="btn btn-success text-white mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Tambah Kategori</a>
                      </div>
                      <div class="col-sm-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                            <input type="text" class="form-control border-left-0" placeholder="Cari">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    @csrf
                    @method('DELETE')
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th class="border-top-0">No.</th>
                                <th class="border-top-0">Nama Kategori</th>
                                <th class="border-top-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>
                                  <div class="form-check">
                                    <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" value="{{ $category->id }}">
                                </div>
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a href="#" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="" class="btn btn-secondary text-white"><i class="fa-regular fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.categories', $category->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="editCategoryName" class="form-label">Nama Kategori</label>
                                                <input type="text" class="form-control" id="editCategoryName" name="name" value="{{ $category->name }}">
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="categoryName" name="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
