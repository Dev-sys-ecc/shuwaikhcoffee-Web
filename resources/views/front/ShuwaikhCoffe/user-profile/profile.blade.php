@section('title')
    {{__('My Profile')}}
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
    <main class="page-content space-top p-b40">
        <div class="container pt-0">
            <div class="profile-area">
                <div class="author-bx">
                    <div class="dz-media">
                        @if($user->photo)
                            @if(filter_var($user->photo, FILTER_VALIDATE_URL))
                                <img style="border-radius: 50%; border: 2px solid #306ff6" class="showimage" src="{{ $user->photo }}" alt="user-image">
                            @else
                                <img style="border-radius: 50%; border: 2px solid #306ff6"  class="showimage" src="{{ asset('assets/front/img/user/'.$user->photo) }}" alt="user-image">
                            @endif
                        @else
                            <img style="border-radius: 50%; border: 2px solid #306ff6"  class="showimage" src="{{ asset('assets/front/img/user/profile.jpg') }}" alt="user-image">
                        @endif
                    </div>
                    <div class="dz-content">
                        <h2 class="name">{{$user->username}}</h2>
                    </div>
                </div>
                <div class="widget_getintuch pb-15">
                    <ul>
                        @if($user->offers->isNotEmpty())
                        <li>
                            <div style="display: flex; align-items: center; justify-content: center" class="icon-bx">
                                <i style="color: #306ff6; font-size: 20px" class="svg-primary fas fa-qrcode"></i>
                            </div>
                            <div class="dz-content">
                                <p class="sub-title">Qr Code</p>
                                <div class="title">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{$user->username}} phone={{$user->number}} offers={{implode(', ', $user->offers->pluck('title')->toArray())}}" />
                                </div>
                            </div>
                        </li>
                        @endif
                        <li>
                            <div class="icon-bx">
                                <svg class="svg-primary" enable-background="new 0 0 507.983 507.983" height="24" viewBox="0 0 507.983 507.983" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m200.75 148.678c11.79-27.061 5.828-58.58-15.03-79.466l-48.16-48.137c-15.999-16.19-38.808-23.698-61.296-20.178-22.742 3.34-42.496 17.4-53.101 37.794-23.286 43.823-29.276 94.79-16.784 142.817 30.775 121.9 198.319 289.559 320.196 320.104 16.452 4.172 33.357 6.297 50.33 6.326 32.253-.021 64.009-7.948 92.487-23.087 35.138-18.325 48.768-61.665 30.443-96.803-3.364-6.451-7.689-12.352-12.828-17.502l-48.137-48.16c-20.894-20.862-52.421-26.823-79.489-15.03-12.631 5.444-24.152 13.169-33.984 22.787-11.774 11.844-55.201-5.31-98.675-48.76s-60.581-86.877-48.876-98.698c9.658-9.834 17.422-21.361 22.904-34.007zm-6.741 165.397c52.939 52.893 124.14 88.562 163.919 48.76 5.859-5.609 12.688-10.108 20.155-13.275 9.59-4.087 20.703-1.9 28.028 5.518l48.137 48.137c5.736 5.672 8.398 13.754 7.157 21.725-1.207 8.191-6.286 15.298-13.645 19.093-33.711 18.115-73.058 22.705-110.033 12.836-104.724-26.412-260.078-181.765-286.489-286.627-9.858-37.009-5.26-76.383 12.86-110.126 3.823-7.318 10.924-12.358 19.093-13.552 1.275-.203 2.564-.304 3.856-.3 6.714-.002 13.149 2.683 17.869 7.457l48.137 48.137c7.407 7.321 9.595 18.421 5.518 28.005-3.153 7.516-7.652 14.394-13.275 20.294-39.804 39.686-4.18 110.817 48.713 163.918z"></path>
                                </svg>
                            </div>
                            <div class="dz-content">
                                <p class="sub-title">{{__('Phone')}}</p>
                                <h6 class="title">{{$user->number}}</h6>
                            </div>
                        </li>
                        <li>
                            <div class="icon-bx">
                                <svg class="svg-primary" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 3H2C1.73478 3 1.48043 3.10536 1.29289 3.29289C1.10536 3.48043 1 3.73478 1 4V20C1 20.2652 1.10536 20.5196 1.29289 20.7071C1.48043 20.8946 1.73478 21 2 21H22C22.2652 21 22.5196 20.8946 22.7071 20.7071C22.8946 20.5196 23 20.2652 23 20V4C23 3.73478 22.8946 3.48043 22.7071 3.29289C22.5196 3.10536 22.2652 3 22 3ZM21 19H3V9.477L11.628 12.929C11.867 13.0237 12.133 13.0237 12.372 12.929L21 9.477V19ZM21 7.323L12 10.923L3 7.323V5H21V7.323Z" fill="#4A3749"></path>
                                </svg>
                            </div>
                            <div class="dz-content">
                                <p class="sub-title">{{__('Email Address')}}</p>
                                <h6 class="title">{{$user->email}}</h6>
                            </div>
                        </li>
                        <li>
                            <div class="icon-bx">
                                <svg class="svg-primary" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9993 5.48404C9.59314 5.48404 7.64258 7.4346 7.64258 9.84075C7.64258 12.2469 9.59314 14.1975 11.9993 14.1975C14.4054 14.1975 16.356 12.2469 16.356 9.84075C16.356 7.4346 14.4054 5.48404 11.9993 5.48404ZM11.9993 12.0191C10.7962 12.0191 9.82096 11.0438 9.82096 9.84075C9.82096 8.6377 10.7962 7.66242 11.9993 7.66242C13.2023 7.66242 14.1776 8.6377 14.1776 9.84075C14.1776 11.0438 13.2023 12.0191 11.9993 12.0191Z" fill="#4A3749"></path>
                                    <path d="M21.793 9.81896C21.8074 4.41054 17.4348 0.0144869 12.0264 5.09008e-05C6.61797 -0.0143851 2.22191 4.35827 2.20748 9.76664C2.16044 15.938 5.85106 21.5248 11.546 23.903C11.6884 23.9674 11.8429 24.0005 11.9991 24C12.1565 24.0002 12.3121 23.9668 12.4555 23.9019C18.1324 21.5313 21.8191 15.9709 21.793 9.81896ZM11.9992 21.7127C7.30495 19.646 4.30485 14.9691 4.38364 9.84071C4.38364 5.63477 7.79323 2.22518 11.9992 2.22518C16.2051 2.22518 19.6147 5.63477 19.6147 9.84071V9.91152C19.6686 15.0154 16.672 19.6591 11.9992 21.7127Z" fill="#4A3749"></path>
                                </svg>
                            </div>
                            <div class="dz-content">
                                <p class="sub-title">{{__('Address')}}</p>
                                <h6 class="title">{{$user->address}}</h6>
                            </div>
                        </li>
                            <li class="gap-3 d-flex align-items-center justify-content-center">
                                <a href="#billing-modal" data-toggle="modal" class="btn btn-lg btn-thin btn-primary  gap-1 rounded-xl ">{{__('Edit Billing Details')}}</a></p>
                                <a href="#shipping-modal" data-toggle="modal" class="btn btn-lg btn-thin btn-primary  gap-1 rounded-xl ">{{__('Edit Shipping Details')}}</a></p>
                            </li>
                        <li>
                            <a href="{{route('edite-user-profile')}}" class="btn btn-lg btn-thin btn-primary w-100 gap-1 rounded-xl ">{{__('Edit Profile')}}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </main>

    <!-- Main Content End -->



    <div class="modal fade" id="billing-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link " id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">{{__('Billing Address')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="{{route('billing-update')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="billing_fname">{{__('First Name')}} *</label>
                                            <input type="text" class="form-control" id="billing_fname" value="{{$user->billing_fname}}" name="billing_fname">
                                        </div><!-- End .form-group -->
                                        @error('billing_fname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="billing_lname">{{__('Last Name')}} *</label>
                                            <input type="text" class="form-control" id="billing_lname" value="{{$user->billing_lname}}" name="billing_lname">
                                        </div><!-- End .form-group -->
                                        @error('billing_lname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="billing_address">{{__('Address')}} *</label>
                                            <input type="text" class="form-control" id="billing_address" value="{{$user->billing_address}}" name="billing_address">
                                        </div><!-- End .form-group -->
                                        @error('billing_address')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="billing_city">{{__('Town / City')}} *</label>
                                            <input type="text" class="form-control" id="billing_city" name="billing_city" value="{{$user->billing_city}}">
                                        </div><!-- End .form-group -->
                                        @error('billing_city')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="billing_email">{{__('Contact Email')}} *</label>
                                            <input class="form-control" type="text" name="billing_email" value="{{$user->billing_email}}">
                                        </div><!-- End .form-group -->
                                        @error('billing_email')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="billing_number">{{__('Phone')}} *</label>
                                            <input type="text" class="form-control" id="billing_number" name="billing_number" value="{{$user->billing_number}}">
                                        </div><!-- End .form-group -->
                                        @error('billing_number')
                                        <p class="text-danger mb-2">{{ $message }}</p>
                                        @enderror

                                        <div class="form-footer w-100">
                                            <button type="submit" class="btn btn-primary m-auto">
                                                <span>{{__('Submit')}}</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <div class="modal fade" id="shipping-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="mb-2 nav-item">
                                    <a class="nav-link" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">
                                        {{__('Shipping Address')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="{{route('user-shipping-update')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="shpping_fname">{{__('First Name')}} *</label>
                                            <input type="text" class="form-control" id="shpping_fname" value="{{$user->shpping_fname}}" name="shpping_fname">
                                        </div><!-- End .form-group -->
                                        @error('shpping_fname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="shpping_lname">{{__('Last Name')}} *</label>
                                            <input type="text" class="form-control" id="shpping_lname" value="{{$user->shpping_lname}}" name="shpping_lname">
                                        </div><!-- End .form-group -->
                                        @error('shpping_lname')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="shpping_address">{{__('Address')}} *</label>
                                            <input type="text" class="form-control" id="shpping_address" value="{{$user->shpping_address}}" name="shpping_address">
                                        </div><!-- End .form-group -->
                                        @error('shpping_address')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="shpping_city">{{__('Town / City')}} *</label>
                                            <input type="text" class="form-control" id="shpping_city" name="shpping_city" value="{{$user->shpping_city}}">
                                        </div><!-- End .form-group -->
                                        @error('shpping_city')
                                        <p class="text-danger">{{convertUtf8($message)}}</p>
                                        @enderror
                                        <div class="form-group">
                                            <label for="shpping_email">{{__('Contact Email')}} *</label>
                                            <input class="form-control" type="text" name="shpping_email" value="{{$user->shpping_email}}">
                                        </div><!-- End .form-group -->
                                            @error('shpping_email')
                                            <p class="text-danger">{{convertUtf8($message)}}</p>
                                            @enderror
                                        <div class="form-group">
                                            <label for="shpping_number">{{__('Phone')}} *</label>
                                            <input type="text" class="form-control" id="shpping_number" name="shpping_number" value="{{$user->shpping_number}}">
                                        </div><!-- End .form-group -->
                                            @error('shpping_number')
                                            <p class="text-danger mb-2">{{ $message }}</p>
                                            @enderror

                                        <div class="form-footer w-100">
                                            <button type="submit" class="btn btn-primary m-auto">
                                                <span>{{__('Submit')}}</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->





    <!-- Menubar -->
    @include('front.ShuwaikhCoffe.layouts.footer')
    <!-- Menubar -->


</div>
@include('front.ShuwaikhCoffe.layouts.footer_scripts')

</body>
</html>
