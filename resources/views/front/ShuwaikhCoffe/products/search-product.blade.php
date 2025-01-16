@section('title')
    {{__('Search Keywords')}}
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
    <main class="page-content space-top p-b60">
        <div class="container">
            <!-- Products Area -->
            <div class="dz-custom-swiper">
                <h1>{{__('Filter Products')}}</h1>
                <div class="swiper mySwiper2 dz-tabs-swiper2" id="productSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <ul class="featured-list">
                                @foreach($products as $product)
                                    <li>
                                        <div class="gap-3 dz-card list">
                                            <div class="dz-media">
                                                <a href="{{ route('front.product.details', [$product->slug, $product->id]) }}"><img src="{{ asset('assets/front/img/product/featured/' . $product->feature_image) }}" alt=""></a>
                                                {{--                                                    <div class="dz-rating"><i class="fa fa-star"></i> {{ $product->rating }}</div>--}}
                                            </div>
                                            <div class="dz-content">
                                                <div class="dz-head">
                                                    <h6 class="title"><a href="{{ route('front.product.details', [$product->slug, $product->id]) }}">{{ $product->title }}</a></h6>
                                                    <ul class="tag-list">
                                                        <p> {{ convertUtf8(strlen($product->summary)) > 48? convertUtf8(substr($product->summary, 0, 48)) . '...': convertUtf8($product->summary) }}
                                                    </ul>
                                                </div>
                                                <ul class="dz-meta">
                                                    <li class="dz-price flex-1">KD {{ convertUtf8($product->current_price) }}</li>
                                                    <li style="cursor: pointer;color: #306ff6" >
                                                        <a  data-product="{{ $product }}"
                                                            data-href="{{ route('add.cart', $product->id) }}" class="main-btn cart-link ">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            {{__('Add To Cart')}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Area -->
        </div>
    </main>

    <!-- Main Content End -->

</div>
@include('front.ShuwaikhCoffe.layouts.footer')


<script src="{{ asset('assets/front/js/items.js') }}"></script>

@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
