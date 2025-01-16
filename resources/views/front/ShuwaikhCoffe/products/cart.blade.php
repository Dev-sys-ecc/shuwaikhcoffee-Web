@section('title')
    {{__('Your Cart')}}
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
    @php
        $cart = session()->get('my-cart');
    @endphp
    @if($cart != null)
        @php
            $cartTotal = 0;
            $countitem = 0;
            if($cart){
            foreach($cart as $p){
                $cartTotal += $p['total'];
                $countitem += $p['qty'];
            }
        }
        @endphp
    @endif
    <!-- Main Content Start -->
    <main id="refreshDiv" class="page-content space-top p-b40">
        <div class="container pt-0">
            @if($cart != null)
            <div class="dz-total-area bg-white">
                <ul class="total-prize">
                    <li class="name">{{__('Total')}} : </li>
                    <li class="prize"><span class="cart-total-view">KD {{$cartTotal}}</span></li>
                </ul>
                <div class="update-cart">
                    <button class="main-btn main-btn-2 btn mb-2 me-2 btn-success" id="cartUpdate" data-href="{{route('cart.update')}}" type="button"><span>{{__('Update Cart')}}</span></button>
                </div>
            </div>
            @endif
            <div class="dz-flex-box p-b100">
                @if($cart != null)
                    @foreach ($cart as $key => $item)
                        @php
                            $id = $item["id"];
                             $product = App\Models\Product::where('id', $id)->first();
                        @endphp
                        @if($product)
                            <div class="dz-cart-list gap-3 remove{{$id}}">
                                <div class="dz-media">
                                    <img src="{{asset('assets/front/img/product/featured/'.$item['photo'])}}" alt="">
                                </div>
                                <div class="dz-content">
                                    <h6 class="title"><a href="{{route('front.product.details',[$product->slug,$product->id])}}">{{convertUtf8($item['name'])}}</a></h6>
                                    <ul class="dz-meta">
                                        <li class="dz-price"><strong>{{__("Product")}} :</strong> KD<span>{{$item['product_price'] * $item["qty"]}}</span></li>
                                    </ul>
                                    <div class=" d-flex align-items-center">
                                        <div class="dz-stepper style-2">
                                            <div class="input-group mb-3">
                                                <input type="number" class="cart_qty text-center form-control" value="{{$item['qty']}}" min="1" name="demo3">
                                            </div>
                                        </div>
                                        <a data-href="{{route('cart.item.remove',$key)}}" class="dz-remove item-remove ms-auto"><i class="feather icon-trash-2"></i>{{__('Remove')}}</a>
                                    </div>
                                    @if (!empty($item["variations"]))
                                        <p><strong>{{__("Variation")}}:</strong> <br>
                                            @php
                                                $variations = $item["variations"];
                                            @endphp
                                            @foreach ($variations as $vKey => $variation)
                                                <span class="text-capitalize">{{str_replace("_"," ",$vKey)}}:</span> {{$variation["name"]}}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif

                                    @if (!empty($item['variations']))
                                        <p>

                                            <strong>{{__("Variation")}}: </strong>
                                            @php
                                                $variations = $item['variations'];
                                                $price = 0;
                                                foreach ($variations as $vKey => $variation) {
                                                    if (is_array($variation) && array_key_exists('price', $variation)) {
                                                        $price += $variation['price'];
                                                    }
                                                }
                                            @endphp
                                           KD <span>{{$price * $item["qty"]}}</span>
                                        </p>
                                    @endif
                                    @if (!empty($item["addons"]))
                                        <p>
                                            <strong>{{__("Add On's")}}:</strong><br>
                                            @php
                                                $addons = $item["addons"];
                                            @endphp
                                            @foreach ($addons as $addon)
                                                {{$addon["name"]}}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                    @if (!empty($item['addons']))
                                        <p>
                                            <strong>{{__("Add On's")}}: </strong>
                                            @php
                                                $addons = $item['addons'];
                                                $addonTotal = 0;
                                                foreach ($addons as $addon) {
                                                    $addonTotal += $addon["price"];
                                                }
                                            @endphp
                                            KD <span>{{$addonTotal * $item["qty"]}}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Handle the case when the product is not found -->
                            <div class="dz-cart-list">
                                <p>{{ __('Product not found') }}</p>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="bg-light py-5 text-center">
                        <h3 class="text-uppercase">{{__('Cart is empty!')}}</h3>
                    </div>
                @endif

            </div>
        </div>
    </main>
    <!-- Main Content End -->

    <!-- Footer Fixed Button -->

    @if ($cart != null)
    <div class="footer-fixed-btn border-bottom">
        <a href="{{route('front.checkout')}}" class="btn btn-lg btn-thin btn-primary w-100 gap-1 rounded-xl ">{{__('Checkout')}}</a>
    </div>
    @endif
    <!-- Main Content End -->

    @include('front.ShuwaikhCoffe.layouts.footer')

</div>
@include('front.ShuwaikhCoffe.layouts.footer_scripts')
</body>
</html>
