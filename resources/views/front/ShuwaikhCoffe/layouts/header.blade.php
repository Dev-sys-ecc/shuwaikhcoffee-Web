<header class="header py-2 mx-auto">
    <div class="header-content">
        <div class="left-content">
            <div class="info">
                <img class="logo-dark" style="width: 55px;" src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="logo">
                <img class="logo-white d-none" style="width: 55px;" src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="logo">
            </div>
        </div>
        <div class="mid-content"></div>
        <div class="right-content d-flex align-items-center gap-4">
            <a style="margin: 0 10px" href="notification.html"  class="notification-badge font-20">
                <div class="item cart cartQuantity" id="cartQuantity">
                    <a href="{{ route('front.cart') }}" class="btn-icon pe-2" target="_self" aria-label="User"
                       title="User">
                        <i style="color: #306ff6 !important;background-color: transparent !important;" class="fas fa-shopping-cart"></i>
                        @php
                            $itemsCount = 0;
                            $cart = session()->get('my-cart');
                            if (!empty($cart)) {
                                foreach ($cart as $p) {
                                    $itemsCount += $p['qty'];
                                }
                            }
                        @endphp
                        <span style="position: absolute; top: -22px;right: 0" class="badge rounded-pill bg-primary cart-quantity">{{ $itemsCount }}</span>
                    </a>
                </div>
            </a>
            <a href="javascript:void(0);" class="icon menu-toggler">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                    <rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                    <rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                </svg>
            </a>
        </div>
    </div>

</header>
