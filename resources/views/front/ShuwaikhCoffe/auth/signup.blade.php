@section('title')
    {{__('Register')}}
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
                    <h3 class="text-center title">{{__('Register')}}</h3>
                </div>
                @if(Session::has('sendmail'))
                    <div class="alert alert-success mb-4">
                        <p>{{Session::get('sendmail')}}</p>
                    </div>
                @endif
                <div class="account-section">
                    <form class="m-b20" action="{{route('user-register-submit')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label" for="name">{{__('Username')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input type="text" id="name" class="form-control" name="username" value="{{Request::old('username')}}">
                            </div>
                            @if ($errors->has('username'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('username')}}</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="email">{{__('Email Address')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input type="email" id="email" name="email" class="form-control" value="{{Request::old('email')}}">
                            </div>
                            @if ($errors->has('email'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="number">{{__('Phone')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input type="number" id="number" name="number" class="form-control" value="{{Request::old('phone')}}">
                            </div>
                            @if ($errors->has('number'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('number')}}</p>
                            @endif
                        </div>
                        <div class="m-b30">
                            <label class="form-label" for="password">{{__('Password')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input type="password" name="password" id="password" class="form-control dz-password" value="{{Request::old('password')}}">
                                <span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
                            </div>
                            @if ($errors->has('password'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('password')}}</p>
                            @endif
                        </div>
                        <div class="m-b30">
                            <label class="form-label" for="password">{{__('Confirmation Password')}} *</label>
                            <div class="input-group input-mini input-lg">
                                <input type="password" name="password_confirmation" id="password" class="form-control dz-password" value="{{Request::old('password_confirmation')}}">
                                <span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <p class="text-danger mb-0 mt-2">{{$errors->first('password_confirmation')}}</p>
                            @endif
                        </div>
                        <button type="submit"  class="btn btn-thin btn-lg w-100 btn-primary rounded-xl">{{__('Register')}}</button>
                        <p class="mt-3 text-center">{{__('Already have an account ?')}} <a class="mr-3" href="{{route('user.login')}}">{{__('Click Here')}}</a> {{__('To login')}}.</p>

                    </form>

                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End  -->

    @include('front.ShuwaikhCoffe.layouts.footer_scripts')

</div>

</body>
</html>
