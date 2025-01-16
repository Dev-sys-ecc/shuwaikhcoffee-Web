@section('title')
{{__('Details')}}
@stop
@include('front.ShuwaikhCoffe.layouts.head')

<body>
<div class="page-wrapper">

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <!-- Preloader end-->

    @include('front.ShuwaikhCoffe.layouts.sidebar')



    @include('front.ShuwaikhCoffe.layouts.header')

    <!-- Main Content Start -->
    <main class="page-content p-b80">
        <div class="container p-0">
            <div class="dz-product-preview bg-primary">
                <div class="swiper product-detail-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($product->product_images as $image)
                        <div class="swiper-slide">
                            <div class="dz-media">
                                <img src="{{asset('assets/front/img/product/sliders/'.$image->image)}}" alt="">
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="dz-product-detail">
                <div class="dz-handle"></div>
                <div class="detail-content">
                    <h4 class="title">{{convertUtf8($product->title)}}</h4>
                    <p>{{convertUtf8($product->summary)}}</p>
                </div>
                <div class="item-wrapper ">
                    <div class="dz-meta-items justify-content-between">
                        <div class="dz-price ">
                            <div class="price"><sub>KD</sub>{{convertUtf8($product->current_price)}}</div>
                        </div>
                        <div id="wishlist" class="dz-quantity">
                            @if(\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content()->contains('id', $product->id))
                                @php
                                    $item = \Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->first();
                                @endphp
                                <a data-quantity="1" data-id="{{ $item->rowId }}" href="javascript:void(0);" class="wishlist_delete item-bookmark style-1 active">
                                    <i class="feather icon-heart-on"></i>
                                </a>
                            @else
                                <a data-quantity="1" data-id="{{ $product->id }}" href="javascript:void(0);" class="add_to_wishlist item-bookmark style-1">
                                    <i class="feather icon-heart-on"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="description">
                        <p class="text-light">{!! nl2br(replaceBaseUrl(convertUtf8($product->description))) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
    <div class="footer fixed bg-white">
        <div class="container">
            <a style="color:white !important;" data-href="{{route('add.cart',$product->id)}}" data-product="{{$product}}" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2 cart-link">{{__('Add To Cart')}}<span class="opacity-25">KD {{convertUtf8($product->current_price)}}</span></a>
        </div>
    </div>

    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->

</div>


<script>
    document.addEventListener('click', function (event) {
        var wishlistButtons = event.target.closest('.add_to_wishlist, .wishlist_delete');

        if (wishlistButtons) {
            event.preventDefault();
            var isDeleteAction = wishlistButtons.classList.contains('wishlist_delete');
            var product_id = wishlistButtons.getAttribute('data-id');
            var token = "{{ csrf_token() }}";
            var path = isDeleteAction ? "{{ route('wishlist.delete') }}" : "{{ route('wishlist.store') }}";

            var xhr = new XMLHttpRequest();
            xhr.open('POST', path, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-Token', token);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    wishlistButtons.innerHTML = '<i class="feather icon-heart-on"></i>';
                    if (xhr.status === 200) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            if (data.status) {
                                toastr["success"](data.message);
                                wishlistButtons.classList.toggle('active', !isDeleteAction);
                                    updateWishlist();
                            } else {
                                toastr["error"](data.message);
                            }
                        } catch (error) {
                            console.error('Error parsing JSON response:', error);
                        }
                    }
                }
            };

            wishlistButtons.innerHTML = '<span><i class="fas fa-spinner fa-spin" style="margin-right: 5px"></i></span>';
            var requestData = isDeleteAction ? 'wishlist_id=' + encodeURIComponent(product_id) : 'product_id=' + encodeURIComponent(product_id) + '&product_qty=1';
            xhr.send(requestData);
        }
    });

    function updateWishlist() {
        var wishlistInformationElement = document.getElementById("wishlist");
        fetch(window.location.href, { method: 'GET' })
            .then(response => response.text())
            .then(data => {
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                var wishlistInformationdetails = tempDiv.querySelector("#wishlist").innerHTML;
                wishlistInformationElement.innerHTML = wishlistInformationdetails;
            })
            .catch(error => console.error('Error fetching data:', error));
    }
</script>

@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
