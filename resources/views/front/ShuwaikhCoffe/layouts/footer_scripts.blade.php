<script src="{{ asset('assets/shuwaikhcoffe/js/jquery.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/js/dz.carousel.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/js/settings.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/js/custom.js') }}"></script>
<script src="{{ asset('assets/shuwaikhcoffe/index.js') }}"></script>

<script>
    "use strict";
    var mainurl = "{{ url('/') }}";
    var lat = '{{ $bs->latitude }}';
    var lng = '{{ $bs->longitude }}';
    var rtl = {{ $rtl }};
    var position = "{{ $be->base_currency_symbol_position }}";
    var symbol = "{{ $be->base_currency_symbol }}";
    var textPosition = "{{ $be->base_currency_text_position }}";
    var currText = "{{ $be->base_currency_text }}";
    var vap_pub_key = "{{ env('VAPID_PUBLIC_KEY') }}";
    var select = "{{ __('Select') }}";
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
{{-- bootstrap popper js --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>

<!--====== Plugin min js ======-->
<script src="{{ asset('assets/front/js/plugin.min.js') }}"></script>

<!--====== Cart js ======-->
<script src="{{ asset('assets/front/js/cart.js') }}"></script>


@if (session()->has('success'))
    <script>
        "use strict";
        toastr["success"]("{{ __(session('success')) }}");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        "use strict";
        toastr["warning"]("{{ __(session('warning')) }}");
    </script>
@endif

@if (session()->has('error'))
    <script>
        "use strict";
        toastr["error"]("{{ __(session('error')) }}");
    </script>
@endif
