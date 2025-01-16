@section('title')
{{__('Home')}}
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
        <main class="page-content bg-white p-b60">
            <div class="container">

                <!-- SearchBox -->
                <form action="{{route('search')}}" method="GET">
                    <div class="search-box">
                        <div class="input-group input-radius input-rounded input-lg">
                            <input id="search_text" type="search" name="query"  placeholder="{{__('Search Keywords')}}" class="form-control" />
                            <span class="input-group-text">
                        <button style="border: none;background-color: transparent;" type="submit">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z" fill="#C9C9C9"/>
						</svg>
                        </button>
					</span>
                        </div>
                    </div>
                </form>
                <div>
                    <select class="form-control" style="color: #0c0b0b; !important; display: none" id="search_results_dropdown"></select>
                </div>
                <!-- SearchBox -->

                <!-- Overlay Card -->
                <div style="margin-top: 15px" class="swiper overlay-swiper1">
                    <div class="swiper-wrapper">
                        @if(count($offers) > 0)
                            @foreach($offers as $offer)
                                <div class="swiper-slide">
                                    <div class="dz-card-overlay style-1">
                                        <div class="dz-media">
                                            <a href="{{route('front.offer.details' , $offer->id)}}">
                                                <img src="{{ asset('assets/front/img/offer/featured/' . $offer->image) }}" alt="image">
                                            </a>
                                        </div>
                                        <div class="dz-info">
                                            <h6 class="title"><a href="{{route('front.offer.details' , $offer->id)}}">{{$offer->title}}</a></h6>
                                            <ul class="dz-meta">
                                                <li class="dz-price"><sup>KD</sup>{{$offer->price}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                                <h1 class="m-auto text-danger">{{__('No Offers Found')}}</h1>
                        @endif
                    </div>
                </div>
                <!-- Overlay Card -->

                <!-- Categories Swiper -->
                <div class="title-bar mb-0">
                    <h5 class="title">{{__('All Categories')}}</h5>
                </div>
                <div class="swiper categories-swiper dz-swiper m-b20">
                    <div class="swiper-wrapper">
                        @if(count($categories) > 0)
                            @foreach($categories as $category)
                                <div class="swiper-slide">
                                    <div class="gap-3 dz-categories-bx">
                                        <div class="icon-bx">
                                            <a href="{{route('front.items')}}">
                                                <img style="width: 40px;" src="{{asset('/assets/front/img/category/'.$category->image)}}"  />
                                            </a>
                                        </div>
                                        <div class="dz-content">
                                            <h6 class="title"><a href="{{route('front.items')}}">{{ $category->name }}</a></h6>
                                            <span class="menus text-primary">{{count($category->products)}} {{__('Products')}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- Categories Swiper -->


                <!-- Featured Beverages -->
                <div class="title-bar">
                    <h5 class="title">{{__('Special')}}</h5>
{{--                    <a href="{{route('front.items')}}">{{__('More')}}</a>--}}
                </div>

                <ul class="featured-list">
                    @foreach($special_product as $product)
                    <li>
                        <div class="gap-3 dz-card list">
                            <div class="dz-media">
                                <a href="{{ route('front.product.details', [$product->slug, $product->id]) }}"><img src="{{ asset('assets/front/img/product/featured/' . $product->feature_image) }}" alt=""></a>
                            </div>
                            <div class="dz-content">
                                <div class="dz-head">
                                    <h6 class="title"><a href="{{ route('front.product.details', [$product->slug, $product->id]) }}">{{ $product->title }}</a></h6>
                                </div>
                                <ul class="dz-meta">
                                    <li class="dz-price flex-1">KD {{$product->current_price}}</li>
                                </ul>
                                <ul class="tag-list">
                                    <p> {{ convertUtf8(strlen($product->summary)) > 48? convertUtf8(substr($product->summary, 0, 48)) . '...': convertUtf8($product->summary) }}
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <!-- Featured Beverages -->
            </div>
        </main>
        <!-- Main Content End -->

        <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
        <!-- Menubar -->

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var path = "{{ route('autosearch') }}";
        var searchInput = document.getElementById('search_text');
        var resultsDropdown = document.getElementById('search_results_dropdown');

        searchInput.addEventListener('input', function () {
            var term = searchInput.value;

            fetch(path + '?term=' + term)
                .then(response => response.json())
                .then(data => {
                    updateAutocomplete(data);
                    toggleDropdown();
                })
                .catch(error => console.error('Error fetching autocomplete data:', error));
        });

        resultsDropdown.addEventListener('input', function () {
            searchInput.value = resultsDropdown.value;
            toggleDropdown();
            resultsDropdown.style.display = 'none';

        });

        function updateAutocomplete(data) {
            resultsDropdown.innerHTML = '';

            if (data.length > 0) {
                data.forEach(function (item) {
                    var option = document.createElement('option');
                    option.value = item.value;
                    option.text = item.value;
                    resultsDropdown.appendChild(option);
                });
            } else {
                var option = document.createElement('option');
                option.text = 'No results found';
                resultsDropdown.appendChild(option);
            }
        }

        function toggleDropdown() {
            var hasOptions = resultsDropdown.options.length > 0;
            resultsDropdown.style.display = hasOptions && searchInput.value.trim() !== '' ? 'block' : 'none';

            resultsDropdown.size = Math.min(10, resultsDropdown.options.length); // Adjust the number of visible options
        }
    });
</script>

@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
