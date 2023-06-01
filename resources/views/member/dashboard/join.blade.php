@section('title', 'Join Kompetisi')
@extends('member.main')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">JOIN KOMPETISI</h3>
                <form action="{{ route('competition.join',$competition->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label">Upload Foto <br>Max. 3mb</label>
                        <div class="col-sm-5">
                            <div class="w-25">
                                <label for="input_banner" style="cursor:pointer">
                                    <img class="img-fluid" id="banner_image" src="{{ asset('assets/admin/images/browse.png') }}" alt="">
                                </label>
                            </div>
                            <input type="file" id="input_banner" class="form-control @error('image') is-invalid @enderror" name="image" hidden>
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="judul" class="col-sm-3 col-form-label">Url Youtube</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="judul" name="url" value="{{ old('url') }}">
                            @error('url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label pt-0">Kategori</label>
                        <div class="col-sm-9">
                            @foreach ($competition->categories as $index => $category)
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input category-checkbox" type="checkbox" value="{{$category->pivot->price}}|{{ $category->id }}" id="category_{{ $category->id }}" name="categories[]">
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8 d-flex align-items-center">
                                    <div class="form-control prices-category border-0">Rp.{{ $category->pivot->price }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="summernote" name="description" rows="10">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                        <div class="col-sm-9">
                            <div class="d-flex align-items-center">
                                <div class="fs-5">: </div>
                                <input type="text" class="form-control border-0 fs-5 bg-white fw-bold" id="total" name="total" value="0" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-start">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-5">
                            <a href="{{ url('/') }}" class="btn btn-secondary me-2 text-white">BATALKAN</a>
                            <button type="submit" class="btn btn-success text-white">BAYAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".category-checkbox").on('change', function() {
            var total = 0;
            $(".category-checkbox:checked").each(function() {
                var price = $(this).val().split("|")[0];
                total += parseInt(price);
            });
            $("#total").val(total);
        });
    });
</script>

@endsection
