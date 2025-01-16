@section('title')
{{__('Offer Details')}}
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
                            <div class="swiper-slide">
                                <div class="dz-media">
                                    <img src="{{ asset('assets/front/img/offer/featured/' . $offer->image) }}" alt="">
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="dz-product-detail">
                <div class="dz-handle"></div>
                <div class="detail-content">
                    <h4 class="title">{{convertUtf8($offer->title)}}</h4>
                    <h3 class="m-auto text-danger">{{__('End In')}} : {{$offer->end_date}}</h3>
                </div>
                <div class="item-wrapper ">
                    <div class="dz-meta-items justify-content-center">
                        <div class="dz-price ">
                            <div class="price gap-1">{{__('Total Price')}} : <sub> KD</sub> {{convertUtf8($offer->price)}}</div>
                        </div>
                    </div>
                    <div class="description">
                        <p class="text-light">{!! nl2br(replaceBaseUrl(convertUtf8($offer->description))) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
    <div class="footer fixed bg-white">
        <div class="container">
            <a style="color:white !important;" href="{{route('hesabePayment' , $offer->id)}}"  class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2 ">{{__('Subscribe Here')}}</a>
        </div>
    </div>

    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->

</div>


@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
