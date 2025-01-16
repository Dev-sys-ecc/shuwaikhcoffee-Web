@section('title')
{{__('My Orders')}}
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
    <main class="page-content space-top">
        <div class="container pt-0">
            <div class="default-tab style-2 mt-1">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="home" role="tabpanel">
                        <ul class="featured-list">
                            @if(count($orders) > 0)
                                @foreach ($orders as $order)
                            <li>
                                <div class="dz-card list">
                                    <div class="dz-content">
                                        <div class="dz-head">
                                            <h6 class="title"><a href="product-detail.html">{{__('Order Number')}} : {{$order->order_number}}</a></h6>
                                            <ul class="tag-list">
                                                <li><a>{{__('Date')}} : </a>{{$order->created_at->format('d-m-Y')}}</li>
                                            </ul>
                                        </div>
                                        <ul class="dz-meta">
                                            <li class="dz-price flex-1">{{$order->currency_symbol_position == 'left' ? $order->currency_symbol : ''}}{{$order->total}}{{$order->currency_symbol_position == 'right' ? $order->currency_symbol : ''}}</li>
                                            <li>
                                                <a href="track-order.html" class="btn btn-primary btn-xs font-13 btn-thin rounded-xl">{{$order->order_status}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                                @endforeach
                            @else
                                <h3 class="text-center text-danger">No Orders Found</h3>
                            @endif
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->

    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->

</div>
@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
