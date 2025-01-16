@include('front.partials.variation-modal')
@php
    $currentPath = Request::path();
@endphp
<div class="menubar-area footer-fixed">
    <div class="toolbar-inner menubar-nav">
        <a  class="nav-link {{ $currentPath === '/' ? 'active' : '' }}" href="{{route('front.index')}}">
            <i class="fi fi-rr-home"></i>
        </a>
        <a class="nav-link {{ $currentPath === 'wishlist' ? 'active' : '' }}" href="{{route('wishlist')}}">
            <i class="fi fi-rr-heart"></i>
        </a>
        @if (auth('web')->check())
        <a class="nav-link {{ $currentPath === 'profile' ? 'active' : '' }}" href="{{route('user-profile')}}">
            <i class="fi fi-rr-user"></i>
        </a>
        @else
            <a class="nav-link {{ $currentPath === 'login' ? 'active' : '' }}" href="{{route('user.login')}}">
                <i class="fas fa-sign-in-alt"></i>
            </a>
        @endif
        <a class="nav-link {{ $currentPath === 'items' ? 'active' : '' }}" href="{{route('front.items')}}">
            <i class="fi fi-rr-box-open-full"></i>
        </a>
    </div>
</div>
