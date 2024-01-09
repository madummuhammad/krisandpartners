@extends('admin.main')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@section('title', 'Detail Kompetisi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">Detail Kompetisi</h3>
                <div class="form-group row">
                    <label for="judul" class="col-sm-3 col-form-label">Judul Kompetisi</label>
                    <div class="col-sm-5">
                        <div class="row">
                         <div class="col-1 pe-0">:</div>
                         <div class="col-11 ps-0">
                            {{ $competition->title }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="waktu_aktif" class="col-sm-3 col-form-label">Waktu Aktif</label>
                <div class="col-sm-5">
                    <div class="row">
                     <div class="col-1 pe-0">:</div>
                     <div class="col-11 ps-0">
                        {{ $competition->from->format('d/m/Y') }} - {{ $competition->to->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-5">
                <div class="row">
                 <div class="col-1 pe-0">:</div>
                 <div class="col-11 ps-0">
                    <?php echo $competition->description ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="kategori" class="col-sm-3 col-form-label pt-0">Kategori</label>
        <div class="col-sm-9">
            @foreach ($categories as $index => $category)
            <div class="row">
                <div class="col-6">
                    <div>
                        @if($competition->categories->contains('id', $category->id))
                        - {{ $category->name }} (Rp. {{ $competition->categories->where('id', $category->id)->first()->pivot->price }})
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <div class="form-group row">
        <label for="banner" class="col-sm-3 col-form-label">Banner</label>
        <div class="col-sm-6">
            <div class="w-100">
                <label for="input_banner">
                    <img class="img-fluid" id="banner_image" src="{{ asset('storage/' . $competition->banner) }}" alt="">
                </label>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
