@section('title')
    {{__('review')}}
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

    <!-- Header -->
    @include('front.ShuwaikhCoffe.layouts.sidebar')



    @include('front.ShuwaikhCoffe.layouts.header')
    <!-- Header -->

    <!-- Main Content Start -->
    <main id="wishlist" class="page-content space-top p-b60">
        <div class="container">
            <div class="row g-3">
                @if(count(\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content()) > 0)
                    @foreach(\Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content() as $item)
                            <div class="col-12 col-sm-6">
                    <div class="gap-3 dz-wishlist-bx">
                        <div class="dz-media">
                            <span><img src="{{ asset('assets/front/img/product/featured/' . $item->model->feature_image) }}" alt=""></span>
                        </div>
                        <div class="dz-info">
                            <div class="dz-head">
                                <h6 class="title"><span>{{$item->name}}</span></h6>
                            </div>
                            <ul class="dz-meta">
                                <li class="price flex-1">KD {{$item->price}}</li>
                                <li>
                                    <a data-quantity="1" data-id="{{ $item->rowId }}" href="javascript:void(0);" class="wishlist_delete item-bookmark style-1 active">
                                        <i class="feather icon-heart-on"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    @endforeach
                @else
                    <p class="text-center text-danger">{{__('No Product Found In Your Wishlist')}}</p>
                @endif
            </div>
        </div>
    </main>
    <!-- Main Content End -->

    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->

</div>
<script>
    document.addEventListener('click', function (event) {
        var wishlistDeleteButton = event.target.closest('.wishlist_delete');

        if (wishlistDeleteButton) {
            event.preventDefault();
            var product_id = wishlistDeleteButton.getAttribute('data-id');
            var token = "{{ csrf_token() }}";
            var path = "{{ route('wishlist.delete') }}"; // تحديد المسار لعملية المسح

            var xhr = new XMLHttpRequest();
            xhr.open('POST', path, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-Token', token);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    wishlistDeleteButton.innerHTML = '<i class="feather icon-heart-on"></i>';
                    if (xhr.status === 200) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            if (data.status) {
                                toastr["success"](data.message);
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

            wishlistDeleteButton.innerHTML = '<span><i class="fas fa-spinner fa-spin" style="margin-right: 5px"></i></span>';
            var requestData = 'wishlist_id=' + encodeURIComponent(product_id); // تحديد البيانات المُرسلة للمسح (معرف المنتج فقط)
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
