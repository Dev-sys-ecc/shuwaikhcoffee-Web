@section('title')
    {{__('Home')}}
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
        .image{
            max-height: fit-content !important;
            overflow: scroll;
        }
        main{
            overflow-y: scroll;"
        }
        .seconddiv{
            overflow-y: visible !important;
        }
    }

    .footer-menu-item {
        cursor: pointer;
    }

    .footer-menu-item .fa-chevron-down {
        transition: transform 0.3s ease;
    }

    .footer-menu-item.collapsed .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>

<body>
@include('front.ShuwaikhCoffe.layouts.sidebar')
@include('front.multipurpose.partials.header')

<div >
    <main class="row bg-light " style="height: 100vh; max-width: 100%;margin: auto;">

         <div  class="image col-md-4 " style="max-height: 100vh">
            <img class="h-100 w-100" src="{{ asset('assets/front/img/' . $be->feature_section_bg_image) }}">
        </div>

        <div class="seconddiv col-md-8 pt-3" style="height: 100%;max-width:100%;  overflow-y: scroll;">
            <div >

                @if ($bs->intro_section == 1)
                <div class="row mb-4">
                    <div class="">
                        <h2 class="h3 font-weight-bold"> {{ convertUtf8($bs->intro_title) }}</h2>
                        <p>
                            {{ convertUtf8($bs->intro_text) }}
                        </p>
                        <div class="mt-3">
                            @if ($bs->intro_main_image)
                            <img style="width:100%" src="{{ asset('assets/front/img/' . $bs->intro_main_image) }}" alt="Starbucks" class="img-fluid">
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                    @if ($bs->news_section == 1)
                        <div class="row mb-4">
                            @forelse ($blogs as $blog)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <img  src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" class="card-img-top lazyload" alt="Oleato Text Card">
                                        <div class="card-body">
                                            <h3 class="h5">{{ convertUtf8($blog->title) }}</h3>
                                            <p>{{ (strlen(strip_tags(convertUtf8($blog->content))) > 100) ? substr(strip_tags(convertUtf8($blog->content)), 0, 100) . '...' : strip_tags(convertUtf8($blog->content)) }}</p>
{{--                                            <a href=""class="btn btn-outline-primary" target="_self" title="{{ __('Read More') }}">{{ __('Read More') }}</a>--}}

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>{{ __('No Blogs') }}.</p>
                            @endforelse
                        </div>
                    @endif

            </div>
            <footer class="py-4">
                <div class="">
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



    </main>
</div>
	<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '430063009526782');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=430063009526782&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<script>
    // Toggle arrow direction
    document.querySelectorAll('.footer-menu-item').forEach(item => {
        item.addEventListener('click', function () {
            this.classList.toggle('collapsed');
        });
    });
</script>
@include('front.ShuwaikhCoffe.layouts.footer_scripts')
</body>

</html>
