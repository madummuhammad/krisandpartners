@extends('admin.main')
@section('title','Settings')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
                    @csrf
                    @method('DELETE')
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
                            <input type="text" class="form-control border-left-0" placeholder="Cari" id="searchCategorySettings">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap" id="tableCategorySettings">
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
                            <td>{{ $category->name }} @if($category->free==1) (Gratis 1 Ketegori) @endif</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                    <a href="#" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<div class="col-sm-9">
    <div class="white-box">
        <h3 class="box-title mb-4">TERM & CONDITION</h3>
        <form action="{{url('admin/settings/term_condition')}}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-sm-12">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="summernote" name="term_condition"
                    rows="10">{{$settings->term_condition}}</textarea> 
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <button class="btn btn-success text-white">Kirim Perubahan</button>
        </form>
    </div>
</div>
</div>
</div>
@foreach ($categories as $category)
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
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="free{{$category->id}}" name="free" value="1" @if($category->free == 1) checked @endif>
                            <label class="form-check-label" for="free{{$category->id}}">Gratis 1 Kategori</label>
                        </div>
                        @error('free')
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
<div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Hapus Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus kategori ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.category.deleteOne', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="text" hidden value="{{$category->id}}" name="categories">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
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
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="free" name="free" value="1">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <label for="free" class="form-label">Gratis 1 Kategori</label>
                        </div>
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
