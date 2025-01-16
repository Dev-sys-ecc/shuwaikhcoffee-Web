@section('title')
    {{ __('Products') }}
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

            <!-- Products Area -->
            <div class="dz-custom-swiper">
                <div thumbsSlider="" class="swiper mySwiper dz-tabs-swiper">
                    <div class="swiper-wrapper">
                        @foreach($categories as $category)
                            <div class="swiper-slide" data-category-id="{{ $category->id }}">
                                <h5 class="title">{{ $category->name }}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper mySwiper2 dz-tabs-swiper2" id="productSwiper">
                    <div class="swiper-wrapper">
                        @foreach($categories as $category)
                            <div class="swiper-slide">
                                <h5 class="title">{{ $category->name }}</h5>
                                <ul class="featured-list">
                                    @foreach($category->products as $product)
                                        <li>
                                            <div class="dz-card list gap-3">
                                                <div class="dz-media">
                                                    <a href="{{ route('front.product.details', [$product->slug, $product->id]) }}"><img src="{{ asset('assets/front/img/product/featured/' . $product->feature_image) }}" alt=""></a>
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
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Area -->
        </div>
    </main>

    <!-- Main Content End -->

</div>
    @include('front.ShuwaikhCoffe.layouts.footer')

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


            resultsDropdown.size = Math.min(10, resultsDropdown.options.length);
        }
    });
</script>
<script src="{{ asset('assets/front/js/items.js') }}"></script>

@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
