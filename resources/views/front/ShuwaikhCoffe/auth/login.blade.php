@section('title')
{{__('Login')}}
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

    <main class="page-content">
        <div class="container py-0">
            <div class="dz-authentication-area">

                <div class="section-head">
                    <h3  class="title text-center">{{__('Login')}}</h3>
                </div>
                <div class="account-section">
                    <form class="m-b30" id="loginForm" action="{{route('user.login')}}" method="POST" >
                        @csrf
                        <div class="mb-4">
                            <label class="form-label" for="name">{{__('Username')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input required type="text" name="username" class="form-control" value="{{old('username')}}">
                            </div>
                            @if(Session::has('err'))
                                <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                            @endif
                            @error('email')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="m-b30">
                            <label class="form-label" for="password">{{__('Password')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input required type="password" id="password" name="password" class="form-control dz-password" />
                                <span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
                            </div>
                            @error('password')
                            <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-thin btn-lg w-100 btn-primary rounded-xl mb-3">{{__('LOG IN')}}</button>
                        <div class="form-choice">
                            <div class="row">
                                <div class="mb-2 col-sm-6">
                                    <a class="d-flex gap-3 btn btn-danger text-white py-2 google-login-btn" href="{{route('front.google.login')}}" >
                                    <i class="fab fa-google"></i>
                                       <span> {{__('Login via Google')}}</span>
                                    </a>
                                </div><!-- End .col-6 -->
                                <div class="col-sm-6">
                                    <a class="d-flex gap-3 btn btn-primary text-white py-2 facebook-login-btn" href="{{route('front.facebook.login')}}" >
                                    <i class="fab fa-facebook-f "></i>
                                        <span>{{__('Login via Facebook')}}</span>
                                    </a>
                                </div><!-- End .col-6 -->
                            </div><!-- End .row -->
                        </div>
                    </form>
                    <div class="text-center account-footer">
                        <a href="{{route('user-register')}}" class="btn btn-secondary btn-lg btn-thin rounded-xl w-100">{{__("Don't have an account")}}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End  -->

    @include('front.ShuwaikhCoffe.layouts.footer_scripts')

</div>

</body>
</html>
