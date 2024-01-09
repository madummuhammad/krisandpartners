@extends('admin.main')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@section('title', 'Edit Kompetisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">Edit Kompetisi</h3>
                <form action="{{ route('admin.competition.update', $competition->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="judul" class="col-sm-3 col-form-label">Judul Kompetisi</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="judul" name="title" value="{{ $competition->title }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktu_aktif" class="col-sm-3 col-form-label">Waktu Aktif</label>
                        <div class="col-sm-5">
                            <input class="form-control input-daterange-datepicker bg-white @error('range') is-invalid @enderror" type="text" name="range" value="{{ $competition->from->format('d/m/Y') }} - {{ $competition->to->format('d/m/Y') }}" readonly>
                            @error('range')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-5">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="summernote" name="description" rows="10">{{ $competition->description }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label pt-0">Kategori</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="selectAll">
                                        <label class="form-check-label" for="is_dropship">
                                            Pilih Semua
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent">Rp</span>
                                        </div>
                                        <input type="number" class="form-control all-prices-category">
                                    </div>
                                </div>
                            </div>
                            
                            @foreach ($categories as $index => $category)
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input category-checkbox" type="checkbox" value="{{$index}}|{{ $category->id }}" id="category_{{ $category->id }}" name="categories[]" {{ $competition->categories->contains('id', $category->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent">Rp</span>
                                        </div>
                                        @if($competition->categories->contains('id', $category->id))
                                        <input type="number" class="form-control prices-category" name="prices[]" value="{{ $competition->categories->where('id', $category->id)->first()->pivot->price }}">
                                        @else
                                        <input type="number" class="form-control prices-category" name="prices[]" value="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="banner" class="col-sm-3 col-form-label">Banner <br>Min. 810 x 1080</label>
                        <div class="col-sm-5">
                            <div class="w-25">
                                @if($competition->banner=="")
                                <label for="input_banner" style="cursor:pointer">
                                    <img class="img-fluid" id="banner_image"
                                    src="{{ asset('assets/admin/images/banner_plus.png') }}" alt="">
                                </label>
                                @else
                                <label for="input_banner" style="cursor:pointer">
                                    <img class="img-fluid" id="banner_image" src="{{ asset('storage/' . $competition->banner) }}" alt="">
                                </label>
                                @endif
                            </div>
                            <input type="file" id="input_banner" class="form-control @error('banner') is-invalid @enderror" name="banner" hidden>
                            @error('banner')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-start">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-5">
                            <a href="{{ url('admin/competition') }}" class="btn btn-secondary me-2 text-white">BATAL</a>
                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
