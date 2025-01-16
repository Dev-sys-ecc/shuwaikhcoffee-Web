@section('title')
    {{__('Offers')}}
@stop
@include('front.ShuwaikhCoffe.layouts.head')
<link type="text/css" rel="stylesheet" href="{{asset('assets/shuwaikhcoffe/style.css')}}" />

<style>
    @media (max-width: 768px) {
        .menu-toggler {
            display: block;
            cursor: pointer;
        }
        .links{
            display: none !important;
        }

    }
    @media (min-width: 769px) {
        .menu-toggler {
            display: none;
        }
    }
    @media (max-width: 850px) {
        .product {
            flex-direction: column;
        }

        .product-right{
            width: 100%;

        }

        .product-left{
            width: 100%;
        }
    }


</style>

<body>
@include('front.ShuwaikhCoffe.layouts.sidebar')
@include('front.multipurpose.partials.header')

<div class="container bg-light">
    @if(count($offers) > 0)
        @foreach($offers as $offer)
            <div class="product-container">
                <div class="product" style=" display: flex;width: 100%; background-color: #306ff6; align-items: center; justify-content: space-between">
                    <div class="product-right">
                        <div
                            class="product-title"
                            style="
                                font-size: 48px;
                                margin-top: 60px;
                                color: white;
                            "
                        >
                            <a class="text-white" href="{{route('front.offer.details' , $offer->id)}}">
                                {{convertUtf8($offer->title)}}
                            </a>
                        </div>
                        <div
                            class="product-description"
                            style="
                                font-size: 24px;
                                max-width: 500px;
                                text-align: center;
                                color: white;
                            "
                        >
                            {!! nl2br(replaceBaseUrl(convertUtf8($offer->description))) !!}
                        </div>
                        <div class="price gap-1 text-white">{{__('Total Price')}} : <sub> KD</sub> {{convertUtf8($offer->price)}}</div>
                        <div
                            class="product-button "
                            style="margin-top: 10px;color: white"
                        >

                            <a style="color:white !important;" href="{{route('hesabePayment' , $offer->id)}}">
                                {{__('Subscribe Here')}}
                            </a>
                        </div>
                    </div>
                    <div class="product-left">
                        <img
                            class="block"
                            style="height: 100%"
                            src="{{ asset('assets/front/img/offer/featured/' . $offer->image) }}"
                        />
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h1 class="m-auto text-center text-danger">{{__('No Offers Found')}}</h1>
    @endif
        <footer class="py-4">
            <div class="container">
                <ul class="footer-menu list-unstyled">
                    <!-- About Us Dropdown -->
                    <li class="footer-menu-item mb-3" data-bs-toggle="collapse" data-bs-target="#aboutUsMenu" aria-expanded="false" aria-controls="aboutUsMenu">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{__('About Us')}}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="collapse " id="aboutUsMenu">
                            <ul class="list-unstyled">
                                <li> {!! nl2br(replaceBaseUrl(convertUtf8($bs->footer_text))) !!}.</li>
                            </ul>
                        </div>
                    </li>

                    <!-- Contact Us Dropdown -->
                    <li class="footer-menu-item mb-3" data-bs-toggle="collapse" data-bs-target="#contactUsMenu" aria-expanded="false" aria-controls="contactUsMenu">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{__('Contact Us')}}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="collapse " id="contactUsMenu">
                            <ul class="list-unstyled">
                                <li>
                                    @if (!empty($bs->contact_address))
                                        <div class="item mt-30">
                                            @php
                                                $addresses = explode(PHP_EOL, $bs->contact_address);
                                            @endphp
                                            <ul>
                                                @foreach ($addresses as $address)
                                                    <li class="d-block mb-0">> {{convertUtf8($address)}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </li>
                                <li>
                                    @if (!empty($bs->contact_mails))

                                        <div class="item mt-30">
                                            {{__('Email Address')}}
                                            <ul>
                                                @php
                                                    $mails = explode(',', $bs->contact_mails);
                                                @endphp
                                                @foreach ($mails as $mail)
                                                    <li class="d-block mb-0">> {{$mail}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </li>
                                <li>
                                    @if (!empty($bs->contact_number))
                                        <div class="item mt-30">
                                            {{__('Phone')}}
                                            <ul>
                                                @php
                                                    $phones = explode(',', $bs->contact_number);
                                                @endphp
                                                @foreach ($phones as $phone)
                                                    <li class="d-block mb-0">> {{$phone}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </li>


                </ul>
                <div style="border-top: 1px solid #333;margin-bottom: 55px">
                    <p class="footer-copyright mt-3"> {!! nl2br(replaceBaseUrl(convertUtf8($bs->copyright_text))) !!}</p>
                </div>
            </div>
        </footer>

</div>





@include('front.ShuwaikhCoffe.layouts.footer_scripts')
</body>

</html>
