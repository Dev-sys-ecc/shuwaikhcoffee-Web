<div class="navbar-container">
    <div class="navbar">
        @php
            $currentPath = Request::path();
        @endphp
        <div class="navbar-left">
            <div  style="width: 55px" class="app-logo">
                <img class="logo-dark" src="{{ asset('assets/front/img/' . $bs->logo) }}" alt="logo">
            </div>
            <div class="links d-flex align-items-center justify-content-between gap-3">

                <div>
                    <a class="nav-link {{ $currentPath === '/' ? 'active' : '' }}" href="{{route('front.index')}}">
                        {{ __('Home') }}
                    </a>
                </div>
                <div>
                    <a class="nav-link {{ $currentPath === 'items' ? 'active' : '' }}" href="{{route('front.items')}}">
                        {{ __('Menu') }}
                    </a>
                </div>

                <div>
                    <a class="nav-link {{ $currentPath === 'offers' ? 'active' : '' }}"href="{{route('front.offers.show')}}">
                        {{ __('Offers') }}
                    </a>
                </div>
                @auth('web')
                    <div>
                        <a class="nav-link {{ $currentPath === 'profile' ? 'active' : '' }}" href="{{route('user-profile')}}">
                            {{ __('My Profile') }}
                        </a>
                    </div>
                @endcan
                <div class="basic-dropdown">
                    <div style="" class="dropdown">
                        <button type="button" style="margin: auto" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{$currentLang->name}}
                        </button>
                        @if (!empty($currentLang))
                            <div class="dropdown-menu" style="">
                                @foreach ($langs as $key => $lang)
                                    <a class="dropdown-item" href="{{ route('changeLanguage', $lang->code) }}">{{ convertUtf8($lang->name) }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="navbar-right">
            @auth('web')
            <div class="sign-in">
                <a class="nav-link" href="{{route('user-logout')}}">
                {{ __('Logout') }}
                </a>
            </div>
            @endcan
            @if (!auth('web')->check())
            <div class="sign-in">
                <a class="nav-link {{ $currentPath === 'login' ? 'active' : '' }}" href="{{route('user.login')}}">
                {{ __('Login') }}
                </a>
            </div>

            @endif
                    <a href="javascript:void(0);" class="icon menu-toggler">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                            <rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                            <rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F"/>
                        </svg>
                    </a>
        </div>
    </div>
</div>
