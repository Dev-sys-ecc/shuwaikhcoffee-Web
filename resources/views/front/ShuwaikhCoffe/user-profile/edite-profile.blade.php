@section('title')
    {{__('Edit Profile')}}
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
    <main class="page-content space-top p-b80">
        <div class="container">
            <form action="{{route('user-profile-update')}}" method="POST" enctype="multipart/form-data" class="edit-profile">
               @csrf
                <div class="profile-image">
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            @if($user->photo)
                            <div id="imagePreview" style="background-image: url('{{ $user->photo ? asset('assets/front/img/user/'.$user->photo) : asset('assets/front/img/user/profile.jpg') }}');"></div>
                            @else
                                <div id="imagePreview" style="background-image: url(assets/images/avatar/1.jpg);"></div>
                            @endif
                                <div class="change-btn">
                                    <input type='file' class="form-control d-none" name="photo" id="imageUpload" accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload">
                                        <i class="fi fi-rr-pencil"></i>
                                    </label>
                                </div>
                        </div>
                    </div>
                </div>
                @error('photo')
                <p class="text-danger" >{{ $message }}</p>
                @enderror
                <div class="mb-4">
                    <label class="form-label" for="name">{{__('Username')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="name" readonly  value="{{$user->username}}" class="form-control">
                    </div>
                </div>
                @error('username')
                <p class="text-danger mb-2">{{ $message }}</p>
                @enderror
                <div class="mb-4">
                    <label class="form-label" for="phone">{{__('Phone')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="tel" value="{{$user->number}}"  name="number" id="phone" class="form-control">
                    </div>
                </div>
                @error('number')
                <p class="text-danger mb-2">{{ $message }}</p>
                @enderror
                <div class="mb-4">
                    <label class="form-label" for="email">{{__('Email Address')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="email" readonly value="{{$user->email}}" name="email" id="email" class="form-control">
                    </div>
                </div>
                @error('email')
                <p class="text-danger mb-2">{{ $message }}</p>
                @enderror

                <div class="mb-4">
                    <label class="form-label" for="address">{{__('Address')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" value="{{$user->address}}" name="address" id="address" class="form-control">
                    </div>
                </div>
            @error('address')
            <p class="text-danger">{{ $message }}</p>
            @enderror
                <div class="mb-4">
                    <label class="form-label" for="old_password">{{__('Password')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="password"  name="old_password" id="old_password" class="form-control">
                    </div>
                </div>
            @error('old_password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
                <div class="mb-4">
                    <label class="form-label" for="new_password">{{__('New Password')}}</label>
                    <div class="input-group input-mini input-sm">
                        <input type="password"  name="new_password" id="new_password" class="form-control">
                    </div>
                </div>
            @error('new_password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        <button type="submit" href="#" style="width: 90%; max-width: 571px; margin: auto; display: block" class="btn btn-lg btn-thin btn-primary gap-1 rounded-xl">{{__('Edit Profile')}}</button>
            </form>
        </div>
    </main>

    <!-- Main Content End -->

    <!-- Menubar -->
    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')


</div>
@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
