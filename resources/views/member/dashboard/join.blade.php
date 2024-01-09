@section('title', 'Join Kompetisi')
@extends('member.main')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@section('content')
<style>
 .bg-gold{
    background-color: #ffd700 !important;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <div class="white-box">
                <h3 class="box-title mb-4">JOIN KOMPETISI</h3>
                <form action="{{ route('competition.join',$competition->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
<!--                     <div class="form-group row">
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
                    </div> -->
<!--                     <div class="form-group row">
                        <label for="judul" class="col-sm-3 col-form-label">Video</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('url') is-invalid @enderror" id="judul" name="url" accept="video/mp4" value="{{ old('url') }}">
                            @error('url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-3 col-form-label pt-0">Kategori</label>
                        <div class="col-sm-9 table-responsive">
                            <span class="font-italic">Untuk mendapatkan <span class="fw-bold">GRATIS Kategori</span>, silahkan pilih kategori spesial terlebih dahulu</span>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($competition->categories as $index => $category)
                                    @if($category->free==1)
                                    <tr class="bg-gold">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" type="checkbox" value="{{$category->pivot->price}}|{{ $category->id }}|{{$category->free}}" id="category_{{ $category->id }}" name="categories[]">
                                                <label class="form-check-label" for="category_{{ $category->id }}">
                                                    {{ $category->name }} @if($category->free==1) (Gratis 1 Ketegori) @endif
                                                </label>
                                            </div> 
                                        </td>
                                        <td>
                                          <div class="form-control border-0">Rp.{{ $category->pivot->price }}</div>
                                      </td>
                                      <td class="d-flex">
                                        <button class="btn btn-primary me-2 dicrement dec-{{$category->id}}" data-id="{{$category->id}}" type="button">-</button>
                                        <input style="width:100px" type="number" min="1" placeholder="jumlah" data-id="{{$category->id}}" class="form-control category-qty qty-{{$category->id}}" value="1" required readonly>
                                        <button class="btn btn-primary ms-2 increment inc-{{$category->id}}" data-id="{{$category->id}}" type="button">+</button>
                                        <button type="button" class="btn btn-success text-white btn-cart cart-{{$category->id}}" data-id="{{$category->id}}"><i class="fa-solid fa-cart-shopping"></i></button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @foreach ($competition->categories as $index => $category)
                                @if($category->free==0)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input category-checkbox" type="checkbox" value="{{$category->pivot->price}}|{{ $category->id }}|{{$category->free}}" id="category_{{ $category->id }}" name="categories[]">
                                            <label class="form-check-label" for="category_{{ $category->id }}">
                                                {{ $category->name }} @if($category->free==1) (Gratis 1 Ketegori) @endif
                                            </label>
                                        </div> 
                                    </td>
                                    <td>
                                      <div class="form-control border-0">Rp.{{ $category->pivot->price }}</div>
                                  </td>
                                  <td class="d-flex">
                                    <button class="btn btn-primary me-2 dicrement dec-{{$category->id}}" data-id="{{$category->id}}" type="button">-</button>
                                    <input style="width:100px" type="number" min="1" placeholder="jumlah" data-id="{{$category->id}}" class="form-control category-qty qty-{{$category->id}}" value="1" required readonly>
                                    <button class="btn btn-primary ms-2 increment inc-{{$category->id}}" data-id="{{$category->id}}" type="button">+</button>
                                    <button type="button" class="btn btn-success text-white btn-cart cart-{{$category->id}}" data-id="{{$category->id}}"><i class="fa-solid fa-cart-shopping"></i></button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            <input type="text" id="selected_category" name="selected_category" value="" hidden>
                        </tbody>
                    </table>
                    <button class="btn btn-danger text-white" id="reset" type="button">Reset</button>
                </div>
            </div>
<!--             <div class="form-group row">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="summernote" name="description" rows="10">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div> -->
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

        var categories=[];
        var selectedCategories=[];
        var total=0;
        var totalFree=0;
        $(".category-checkbox").each(function() {
            var categoryData = $(this).val().split("|");
            var qty = updateQty(categoryData[1]);
            categories.push({
                category_id: categoryData[1],
                isFree: parseInt(categoryData[2]) === 1,
                price:categoryData[0],
                free_count:0,
                free:false,
                qty:qty,
                checked:false,
                selected:false,
            });
        });

        function updateQty(id_category) {
            var select = null;
            $(".category-qty").each(function() {
                var id = $(this).data('id');
                if (id_category == id) {
                    select = $(this).val();
                }
            });
            return select;
        }

        $(".category-checkbox").on('change', function() {

            if ($(this).prop("checked")) {
                var categoryID = $(this).val().split("|")[1];
                categories.forEach(function(item) {
                    if(item.category_id==categoryID){
                        if(item.selected==true){
                            $(this).prop("checked", true);
                        }
                        item.checked=true;
                    }
                });

            } else {
               var categoryID = $(this).val().split("|")[1];
               categories.forEach(function(item, index) {
                if(item.category_id==categoryID){
                    if(item.selected==false){
                        item.checked=false;
                    } else {
                        $('#category_'+item.category_id).prop("checked", true)
                        // $('#category_'+item.id).prop("checked", true);
                    }
                }
            });
           }

           console.log(categories)
       })

        $("#reset").on('click', function() {
            categories.forEach(function(item) {
                item.checked = false;
                item.selected = false;
                item.qty = 1;
                item.free_count = 0;
                item.free = false;
            });

            total = 0;
            totalFree = 0;

            $(".form-check-input").prop("checked", false);
            $(".btn-cart").removeClass('btn-light text-dark').addClass('btn-success text-white');
            $(".dicrement, .increment").removeClass('btn-light').addClass('btn-primary');

            console.log(categories)
            $(".category-qty").val(1)
            $("#selected_category").val(JSON.stringify(categories));
            $("#total").val(total);
        });

        $(".btn-cart").on('click',function(){
            var id=$(this).data('id');
            var html=$(this);
            var input=$("."+id);
            var inc=$(".inc-"+id)
            var dec=$(".dec-"+id)
            categories.forEach(function(item, index) {
                if(item.category_id==id){
                    if(item.checked==true){                        
                        if(item.selected==false){
                            html.removeClass('btn-success')
                            html.removeClass('text-white')
                            html.addClass('btn-light')
                            html.addClass('text-dark')
                            dec.removeClass('btn-primary')
                            dec.addClass('btn-light')
                            inc.removeClass('btn-primary')
                            inc.addClass('btn-light')

                            if(item.isFree==true){
                                totalFree=totalFree+parseInt(item.qty);
                                total=total+(parseInt(item.qty)*parseInt(item.price));
                            } else {
                                if(totalFree==0){
                                    total += (parseInt(item.price)*item.qty);
                                } else {
                                    if(totalFree<item.qty){
                                        total += (parseInt(item.price)*(item.qty-totalFree));
                                    }
                                    item.free=true;
                                }
                                if(totalFree>=item.qty){
                                    item.free_count=parseInt(item.qty);
                                } else {
                                    item.free_count=parseInt(totalFree);
                                }
                                totalFree=totalFree-parseInt(item.qty);
                                if(totalFree<0){
                                    totalFree=0
                                }
                            }
                            console.log(totalFree)
                            item.selected=true;
                        }
                    }
                }
            });
            $("#selected_category").val(JSON.stringify(categories))
            console.log(categories)
            $("#total").val(total);
        })

        $(".increment").on('click',function(){
            var id=$(this).data('id');
            var input=$(".qty-"+id);
            var qty=updateQty(id);
            categories.forEach(function(item) {
                if(item.category_id==id){
                    if(item.selected==false){
                        item.qty=parseInt(qty)+1;
                        input.val(parseInt(qty)+1);
                        return;
                    }
                }
            });
        })

        $(".dicrement").on('click',function(){
            var id=$(this).data('id');
            var input=$(".qty-"+id);
            var qty=updateQty(id);
            if(qty<=1){
                return;
            }
            categories.forEach(function(item) {
                if(item.category_id==id){
                    if(item.selected==false){
                        item.qty=parseInt(qty)-1;
                        input.val(parseInt(qty)-1);
                        return;
                    }
                }
            });
        });
    });
</script>

<!-- <script>
    $(document).ready(function() {

        var categories=[];
        var selectedCategories=[];
        var total=0;
        $(".category-checkbox").each(function() {
            var categoryData = $(this).val().split("|");
            var qty = updateQty(categoryData[1]);
            categories.push({
                category_id: categoryData[1],
                isFree: parseInt(categoryData[2]) === 1,
                price:categoryData[0],
                free_count:0,
                free:false,
                qty:qty,
                checked:false
            });
        });

        $("#total").val(total);

        var totalFree=0;
        var totalPay=0;
        $(".category-checkbox").on('change', function() {

            if ($(this).prop("checked")) {
                var categoryID = $(this).val().split("|")[1];
                var categoryData = $(this).val().split("|");
                var qty = updateQty(categoryData[1]);
                categories.forEach(function(item) {
                    if(item.category_id==categoryID){
                        console.log(item)
                        item.checked=true;
                        if(item.isFree==true){
                            totalFree=totalFree+parseInt(qty);
                            total += (parseInt(item.price)*qty);
                        } else {
                            if(totalFree<=0){
                                total += (parseInt(item.price)*qty);
                            } else {
                                if(totalFree<qty){
                                    total += (parseInt(item.price)*(qty-totalFree));
                                }
                                item.free=true;
                            }
                            if(totalFree>=qty){
                                item.free_count=parseInt(qty);
                            } else {
                                item.free_count=parseInt(totalFree);
                            }
                            totalFree=totalFree-parseInt(qty);
                        }
                    }
                });

            } else {
               var categoryID = $(this).val().split("|")[1];
               var categoryData = $(this).val().split("|");
               var qty = updateQty(categoryData[1]);
               categories.forEach(function(item, index) {
                if(item.category_id==categoryID){
                    item.checked=false;
                    item.free_count=0;
                    if(item.isFree==true){
                        total=total-(parseInt(item.price)*qty);
                        totalFree=totalFree-parseInt(qty)
                    } else {
                        if(item.free==false){
                            total=total-(parseInt(item.price)*qty);
                        } else {
                            if(totalFree<0){
                                total=total-(parseInt(item.price)*(parseInt(qty)-(parseInt(qty)+totalFree)));
                            }
                            item.free=false;
                        }
                        totalFree=totalFree+parseInt(qty)
                    }

                }
            });

               selectedCategories = selectedCategories.filter(function(item,index) {
                return item.category_id !== categoryID;
            });
           }
           console.log(categories)
           console.log(totalFree)
           $("#selected_category").val(JSON.stringify(categories))
           $("#total").val(total);
       })


        function updateQty(id_category) {
            var select = null;
            $(".category-qty").each(function() {
                var id = $(this).data('id');
                if (id_category == id) {
                    select = $(this).val();
                }
            });
            return select;
        }

        $(".increment").on('click',function(){
            var id=$(this).data('id');
            var input=$("."+id);
            var qty=updateQty(id);


            input.val(parseInt(qty)+1);

            var categoryID = id;
            categories.forEach(function(item) {
                if(item.category_id==categoryID){
                    item.qty=parseInt(qty)+1;
                    if(item.checked==true){
                        if(item.isFree==true){
                            total=total+(parseInt(item.price));
                            totalFree=totalFree+1;
                        } else {
                            if(totalFree<=0){
                                total =total+(parseInt(item.price));
                            } else {
                                item.free=true;
                                item.free_count=item.free_count+1
                            }
                            totalFree=totalFree-1;
                            // console.log('qqq',qty)
                        }
                    }
                }
            });
            console.log(categories)
            console.log(totalFree)
            $("#selected_category").val(JSON.stringify(categories))
            $("#total").val(total);
        })

        $(".dicrement").on('click',function(){
            var id=$(this).data('id');
            var input=$("."+id);
            var qty=updateQty(id);
            if(qty<=1){
                return;
            }
            input.val(parseInt(qty)-1);
            console.log('qty',qty)

            var categoryID = id;
            categories.forEach(function(item) {
                if(item.category_id==categoryID){
                    item.qty=parseInt(qty)-1;
                    if(item.checked==true){
                        if(item.isFree==true){
                            total=total-(parseInt(item.price));
                            totalFree=totalFree-1;
                        } else {
                            if(totalFree==0){
                                item.free_count=item.free_count-1
                            } else {
                                if(totalFree<0){
                                    total =total-(parseInt(item.price));
                                } else {
                                    item.free_count=item.free_count-1;
                                }

                            }
                            totalFree=totalFree+1;
                            // if(totalFree<=0){
                            //     total =total-(parseInt(item.price));
                            // } else {
                            // }
                            // totalFree=totalFree+1;
                        }
                    } 
                }
            });
            console.log(categories)
            console.log(totalFree)
            $("#selected_category").val(JSON.stringify(categories))
            $("#total").val(total);
        });


        // $(".category-qty").on('change', function() {
        //     var categoryID = $(this).data('id');
        //     var qty = parseInt($(this).val());

        //     categories.forEach(function(item) {
        //         if(item.category_id==categoryID){
        //             item.qty=qty;
        //             if(item.checked==true){
        //                 if(item.isFree==true){
        //                     totalFree=totalFree+parseInt(qty);
        //                     total += (parseInt(item.price)*qty);
        //                 } else {
        //                     if(totalFree==0){
        //                         total += (parseInt(item.price)*qty);
        //                     } else {
        //                         item.free=true;
        //                     }
        //                     totalFree=totalFree-parseInt(qty);
        //                 }
        //             }
        //         }
        //     });

        //     console.log('jml categ',totalFree)
        //     var total = 0;
        //     categories.forEach(function(item) {
        //         if(item.checked==true){
        //             if(item.free!==true){
        //                 total += (parseInt(item.price)*item.qty);
        //                 console.log(parseInt(item.price)*item.qty)
        //             } else {
        //                 total += (parseInt(item.price)*item.qty-item.price);
        //             }
        //         }
        //     });
        //     $("#selected_category").val(JSON.stringify(categories))
        //     $("#total").val(total);
        // });
    });
</script> -->

<!-- <script>
    $(document).ready(function() {

        var categories=[];
        var selectedCategories=[];
        var total=0;
        $(".category-checkbox").each(function() {
            var categoryData = $(this).val().split("|");
            var qty = updateQty(categoryData[1]);
            categories.push({
                category_id: categoryData[1],
                isFree: parseInt(categoryData[2]) === 1,
                price:categoryData[0],
                free:false,
                qty:qty,
                checked:false
            });
        });

        $("#total").val(total);

        var isAnyFree=false;
        $(".category-checkbox").on('change', function() {

            if ($(this).prop("checked")) {
                var categoryID = $(this).val().split("|")[1];
                var categoryData = $(this).val().split("|");
                var qty = updateQty(categoryData[1]);
                categories.forEach(function(item) {
                    if(item.category_id==categoryID){
                        item.checked=true
                    }
                });

                selectedCategories.push({
                    price:categoryData[0],
                    category_id: categoryData[1],
                    qty:qty,
                    isFree: parseInt(categoryData[2]) === 1,
                });



                if(selectedCategories[selectedCategories.length-2] && selectedCategories[selectedCategories.length-2].isFree && !isAnyFree){
                    isAnyFree=true;
                    categories.filter(function(item) {
                        if(item.category_id==selectedCategories[selectedCategories.length-1].category_id){
                            item.free=true
                        }
                    });
                }


            } else {
                var categoryID = $(this).val().split("|")[1];
                categories.forEach(function(item, index) {
                    if(item.category_id==categoryID){
                        item.checked=false;

                        if(item.free==true){
                            item.free=false;
                            isAnyFree=false;
                        }
                    }
                });

                selectedCategories = selectedCategories.filter(function(item,index) {

                    if(categoryID==item.category_id){
                        if(selectedCategories[index+1]){
                            console.log(selectedCategories[index+1].category_id);
                            categories.filter(function(items) {
                                if(items.category_id==selectedCategories[index+1].category_id){
                                    console.log(items)
                                    if(items.free==true){
                                        items.free=false;
                                    }
                                }
                            })
                        }
                    }
                    return item.category_id !== categoryID;
                });
            }

            console.log('selected',categories)
            console.log(categories)
            var total = 0;
            categories.forEach(function(item) {
                if(item.checked==true){
                    if(item.free!==true){
                        total += (parseInt(item.price)*item.qty);
                    } else {
                        total += (parseInt(item.price)*item.qty-item.price);
                    }
                }
            });
            $("#selected_category").val(JSON.stringify(categories))
            $("#total").val(total);
        })


        function updateQty(id_category) {
            var select = null;
            $(".category-qty").each(function() {
                var id = $(this).data('id');
                if (id_category == id) {
                    select = $(this).val();
                }
            });
            return select;
        }


        $(".category-qty").on('change', function() {
            var categoryID = $(this).data('id');
            var qty = parseInt($(this).val());

            categories.forEach(function(item) {
                if(item.category_id==categoryID){
                    item.qty=qty;
                }
            });

            console.log('jml categ',categories)
            var total = 0;
            categories.forEach(function(item) {
                if(item.checked==true){
                    if(item.free!==true){
                        total += (parseInt(item.price)*item.qty);
                        console.log(parseInt(item.price)*item.qty)
                    } else {
                        total += (parseInt(item.price)*item.qty-item.price);
                    }
                }
            });
            $("#selected_category").val(JSON.stringify(categories))
            $("#total").val(total);
        });
    });
</script> -->
@endsection
