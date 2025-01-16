@section('title')
        {{__('Checkout')}}
@stop
@include('front.ShuwaikhCoffe.layouts.head')
<link rel="stylesheet" href="{{asset('assets/front/css/qr-menu.css')}}">


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
    <main class="page-content space-top p-b80">
        <div class="container">
            <div class="dz-flex-box">
                <form action="" method="POST" id="payment" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <input type="hidden" value="home_delivery" name="serving_method"  />
                        <div class="form shipping-info">
                            <div class="shop-title-box">
                                <h3 style="color:#306ff6;">{{__('Shipping Address')}}</h3>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="field-label">{{__('First Name')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $sfname = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $sfname = auth('web')->user()->shpping_fname;
                                                }
                                            } else {
                                                $sfname = old('shipping_fname');
                                            }
                                        @endphp
                                        <input class="form-control" type="text"  name="shipping_fname" value="{{$sfname}}">
                                        @error('shipping_fname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-label">{{__('Last Name')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $slname = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $slname = auth('web')->user()->shpping_lname;
                                                }
                                            } else {
                                                $slname = old('shipping_lname');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="shipping_lname" value="{{$slname}}">
                                        @error('shipping_lname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Address')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $saddress = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $saddress = auth('web')->user()->shpping_address;
                                                }
                                            } else {
                                                $saddress = old('shipping_address');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="shipping_address" value="{{$saddress}}">
                                        @error('shipping_address')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Town / City')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $scity = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $scity = auth('web')->user()->shpping_city;
                                                }
                                            } else {
                                                $scity = old('shipping_city');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="shipping_city" value="{{$scity}}">
                                        @error('shipping_city')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Contact Email')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $smail = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $smail = auth('web')->user()->shpping_email;
                                                }
                                            } else {
                                                $smail = old('shipping_email');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="shipping_email" value="{{$smail}}">
                                        @error('shipping_email')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="field-label">{{__('Phone')}} *</div>

                                    @php
                                        $snumber = '';
                                        if(empty(old())) {
                                            if (Auth::guard('web')->check()) {
                                                $snumber = auth('web')->user()->shpping_number;
                                            }
                                        } else {
                                            $snumber = old('shipping_number');
                                        }

                                        $sccode = '';
                                        if(empty(old())) {
                                            if (Auth::guard('web')->check()) {
                                                $sccode = auth('web')->user()->shpping_country_code;
                                            }
                                        } else {
                                            $sccode = old('shipping_country_code');
                                        }
                                    @endphp
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="shipping_number" class="form-control" value="{{$snumber}}">
                                    </div>
                                    @error('shipping_country_code')
                                    <p class="text-danger mb-2">{{ $message }}</p>
                                    @enderror
                                    @error('shipping_number')
                                    <p class="text-danger mb-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if ($bs->postal_code == 0 && count($scharges) > 0)
                                    <div class="col-md-12 mb-4">
                                        <div id="shippingCharges">
                                            <div class="field-label mb-2">{{__('Shipping Charges')}} *</div>
                                            @foreach ($scharges as $scharge)
                                                <div class="d-flex justify-content-between align-items-center form-check form-check">
                                                    <div class="d-flex  align-items-center">
                                                    <input @if ($rtl) style="margin-right:-30px;" @else style="margin-right:10px;" @endif class="form-check-input" type="radio" data="{{!empty($scharge->free_delivery_amount) && cartTotal() >= $scharge->free_delivery_amount ? 0 : $scharge->charge}}" name="shipping_charge" id="scharge{{$scharge->id}}" value="{{$scharge->id}}" {{$loop->first ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="scharge{{$scharge->id}}">{{$scharge->title}}</label>
                                                    </div>

                                                    <div>
                                                        +
                                                    <strong>
                                                        {{$be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$scharge->charge}}{{$be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}}
                                                    </strong>
                                                    @if (!empty($scharge->free_delivery_amount))
                                                        (@lang('Free Delivery for Orders over')

                                                        {{$be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$scharge->free_delivery_amount - 1}}{{$be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}})

                                                    @endif
                                                    </div>
                                                </div>

                                                <p class="mb-0  pl-3 mb-1"><small>{{$scharge->text}}</small></p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12">
                                    <div class="form-check form-check-inline mb-3">
                                        <input name="same_as_shipping" class="form-check-input ml-2 mr-2" type="checkbox" id="sameAsSHipping" value="1">
                                        <label class="form-check-label" for="sameAsSHipping">{{__('Billing Address will be Same as Shipping Address')}}</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="" id="billingAddress" >
                        <div class="form billing-info">
                            <div class="shop-title-box">
                                <h3 style="color:#306ff6;">{{__('Billing Address')}}</h3>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="field-label">{{__('First Name')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $bfname = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $bfname = auth('web')->user()->billing_fname;
                                                }
                                            } else {
                                                $bfname = old('billing_fname');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="billing_fname" value="{{$bfname}}">
                                        @error('billing_fname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="field-label">{{__('Last Name')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $blname = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $blname = auth('web')->user()->billing_lname;
                                                }
                                            } else {
                                                $blname = old('billing_lname');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="billing_lname" value="{{$blname}}">
                                        @error('billing_lname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Address')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $baddress = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $baddress = auth('web')->user()->billing_address;
                                                }
                                            } else {
                                                $baddress = old('billing_address');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="billing_address" value="{{$baddress}}">
                                        @error('billing_address')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Town / City')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $bcity = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $bcity = auth('web')->user()->billing_city;
                                                }
                                            } else {
                                                $bcity = old('billing_city');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="billing_city" value="{{$bcity}}">
                                        @error('billing_city')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="field-label">{{__('Contact Email')}} *</div>
                                    <div class="field-input">
                                        @php
                                            $bmail = '';
                                            if(empty(old())) {
                                                if (Auth::guard('web')->check()) {
                                                    $bmail = auth('web')->user()->billing_email;
                                                }
                                            } else {
                                                $bmail = old('billing_email');
                                            }
                                        @endphp
                                        <input class="form-control" type="text" name="billing_email" value="{{$bmail}}">
                                        @error('billing_email')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="field-label">{{__('Phone')}} *</div>

                                    @php
                                        $bnumber = '';
                                        if(empty(old())) {
                                            if (Auth::guard('web')->check()) {
                                                $bnumber = auth('web')->user()->billing_number;
                                            }
                                        } else {
                                            $bnumber = old('billing_number');
                                        }

                                        $bccode = '';
                                        if(empty(old())) {
                                            if (Auth::guard('web')->check()) {
                                                $bccode = auth('web')->user()->billing_country_code;
                                            }
                                        } else {
                                            $bccode = old('billing_country_code');
                                        }
                                    @endphp
                                    <div class="input-group mb-3">

                                        <input style="border-left: 1;" class="form-control" type="text" name="billing_number" class="form-control" value="{{$bnumber}}">
                                    </div>
                                    @error('billing_country_code')
                                    <p class="text-danger mb-2">{{ $message }}</p>
                                    @enderror
                                    @error('billing_number')
                                    <p class="text-danger mb-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($bs->postal_code == 1)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-label">{{__('Postal Code')}} ({{__('Delivery Area')}}) *</div>
                                <div class="field-input">
                                    @php
                                        $snumber = '';
                                        if(empty(old())) {
                                            if (Auth::guard('web')->check()) {
                                                $snumber = auth('web')->user()->shipping_number;
                                            }
                                        } else {
                                            $snumber = old('shipping_number');
                                        }
                                    @endphp
                                    <select  name="postal_code" class="form-control select2">
                                        <option value="" selected disabled>{{__('Select a postal code')}}</option>
                                        @foreach ($postcodes as $postcode)
                                            <option value="{{$postcode->id}}" data="{{!empty($postcode->free_delivery_amount) && (cartTotal() >= $postcode->free_delivery_amount) ? 0 : $postcode->charge}}">
                                                @if (!empty($postcode->title))
                                                    {{$postcode->title}} -
                                                @endif
                                                {{$postcode->postcode}}

                                                ({{__('Delivery Charge')}} - {{$be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$postcode->charge}}{{$be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}}
                                                @if (!empty($postcode->free_delivery_amount))
                                                    ,  @lang('Free Delivery for Orders over')
                                                    {{$be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : ''}}{{$postcode->free_delivery_amount - 1}}{{$be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : ''}}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('postal_code')
                                    <p class="text-danger">{{convertUtf8($message)}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="shop-title-box mt-3">
                        <h3 style="color:#306ff6;">{{ __('Order Total') }}</h3>
                    </div>

                    <div id="cartTotal">
                        <ul class="cart-total-table">
                            <li style="{{ $rtl == 1 ?'direction:rtl !important':'' }}">
                                <span class="col-title">{{ __('Cart Total') }}</span>
                                <span dir="ltr">
                    {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}<span
                                        data="{{ cartTotal() }}" class="subtotal">{{ cartTotal() }}</span>{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                </span>
                            </li>
                            <li style="{{ $rtl == 1 ?'direction:rtl !important':'' }}">
                                <span class="col-title">{{ __('Discount') }}</span>
                                <span  dir="ltr">
                    <i class="fas fa-minus"></i>
                    {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}<span data="{{ $discount }}">{{ $discount }}</span>
                    {{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                </span>

                            </li>
                            <li style="{{ $rtl == 1 ?'direction:rtl !important':'' }}">
                                <span class="col-title">{{ __('Cart Subtotal') }}</span>
                                <span dir="ltr">
                {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}<span
                                        data="{{ cartTotal() - $discount }}" class="subtotal"
                                        id="subtotal">{{ cartTotal() - $discount }}</span>{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                </span>
                            </li>
                            <li style="{{ $rtl == 1 ?'direction:rtl !important':'' }}">
                                <span class="col-title">{{ __('Tax') }}</span>
                                <span  dir="ltr">
                    <i class="fas fa-plus"></i>
                    {{ $be->base_currency_symbol_position == 'left' ? $be->base_currency_symbol : '' }}<span
                                        data-tax="{{ tax() }}" id="tax">{{ tax() }}</span>{{ $be->base_currency_symbol_position == 'right' ? $be->base_currency_symbol : '' }}
                </span>
                            </li>


                        </ul>
                    </div>
                    <div class="coupon mt-2">
                        <h3 style="color: #306ff6;" class="mb-3">{{__('Coupon')}}</h3>
                        <div class="form-group d-flex gap-2">
                            <input type="text" class="form-control" name="coupon" value="">
                            <button style="background-color:#306ff6 !important;" class="btn btn-primary" type="button" onclick="applyCoupon();">{{__('Apply')}}</button>
                        </div>
                    </div>
                    <div class="payment-options">
                        <h4 class="mb-4">{{ __('Pay Via') }}</h4>
                        @include('front.multipurpose.product.payment-gateways')
                        @error('gateway')
                        <p class="text-danger mb-0">{{ convertUtf8($message) }}</p>
                        @enderror
                        <div class="placeorder-button {{$rtl == 1 ? 'text-right' : 'text-left'}} mt-4" style="{{ $rtl == 1 ? 'text-align:right !important':''}}">
                            <button style="background-color:#306ff6 !important;"  type="submit" form="payment" id="placeOrderBtn"><span
                                    class="btn text-white border-0 btn-title">{{ __('Place Order') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Main Content End -->

    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->

</div>


<script>

    document.querySelector(".input-check").checked = true;

    var tabid = document.querySelector(".input-check:checked").dataset.tabid;
    document.getElementById('payment').setAttribute('action', document.querySelector(".input-check:checked").dataset.action);


    function applyCoupon() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('front.coupon')}}", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                console.log(data);
                if (data.status == 'success') {
                    toastr["success"](data.message);
                    document.querySelector("input[name='coupon']").value = '';
                    var cartInformationElement = document.getElementById("cartTotal");
                    fetch(window.location.href, { method: 'GET' })
                        .then(response => response.text())
                        .then(data => {
                            var tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data;

                            var cartInformationdetails = tempDiv.querySelector("#cartTotal").innerHTML;

                            cartInformationElement.innerHTML = cartInformationdetails;
                        })
                        .catch(error => console.error('Error fetching data:', error));
                } else {
                    toastr["error"](data.message);
                }
            }
        };
        var coupon = document.querySelector("input[name='coupon']").value;
        var params = JSON.stringify({
            coupon: coupon,
            _token: "{{ csrf_token() }}"
        });
        xhr.send(params);
    }

    document.querySelector("input[name='coupon']").addEventListener('keypress', function(e) {
        var code = e.which;
        if (code == 13) {
            e.preventDefault();
            applyCoupon();
        }
    });



    function loadTimeFrames(date, time) {
        if (date.length > 0) {
            fetch(`{{route('front.timeframes')}}?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    console.log('time frames', data);
                    let options = `<option value="" selected disabled>Select a Time Frame</option>`;
                    if (data.status == 'success') {
                        document.getElementById('deliveryTime').removeAttribute('disabled');
                        let timeframes = data.timeframes;
                        for (let i = 0; i < timeframes.length; i++) {
                            options += `<option value="${timeframes[i].id}" ${time == timeframes[i].id ? 'selected' : ''}>${timeframes[i].start} - ${timeframes[i].end}</option>`
                        }
                    } else {
                        document.getElementById('deliveryTime').setAttribute('disabled', 'disabled');
                        toastr["error"](data.message);
                    }
                    document.getElementById('deliveryTime').innerHTML = options;
                })
                .catch(error => console.error('Error fetching time frames:', error));
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        loadTimeFrames("{{old('delivery_date')}}", "{{old('delivery_time')}}");

        document.querySelectorAll('.delivery-date').forEach(function(datepicker) {
            datepicker.addEventListener('change', function() {
                loadTimeFrames(this.value);
            });
        });
    });

    document.querySelectorAll('.field-input.cross i.fa-times-circle').forEach(function(icon) {
        icon.addEventListener('click', function() {
            this.closest('.field-input').querySelector('input').value = '';
            this.closest('.field-input').classList.remove('cross-show');
            document.getElementById('deliveryTime').innerHTML = '<option value="" selected disabled>Select a Time Frame</option>';
            document.getElementById('deliveryTime').setAttribute('disabled', 'disabled');
        });
    });
</script>
<script>
        document.addEventListener("DOMContentLoaded", function() {
        var sameAsShippingCheckbox = document.getElementById("sameAsSHipping");
        var billingAddressElement = document.getElementById("billingAddress");

        sameAsShippingCheckbox.addEventListener("change", function() {
        if (this.checked) {
        billingAddressElement.style.display = "none";
    } else {
        billingAddressElement.style.display = "block";
    }
    });
    });
    function setBillingCountryCode(code) {
            document.querySelector('input[name="billing_country_code"]').value = code;
            document.getElementById('billingCountryButton').innerText = code;
    }
        function setShippingCountryCode(code) {
            document.querySelector('input[name="shipping_country_code"]').value = code;
            document.getElementById('shippingCountryButton').innerText = code;
        }

</script>



@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
