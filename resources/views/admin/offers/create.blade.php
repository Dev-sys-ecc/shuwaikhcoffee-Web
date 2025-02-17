@extends('admin.layout')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Add Offer</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Items Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Add Offer</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Add Offer</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('admin.offer.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            {{-- Featured image upload end --}}
                            <form id="ajaxForm" class="" action="{{ route('admin.offer.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-12 mb-2">
                                                <label for="image"><strong>Featured Image</strong></label>
                                            </div>
                                            <div class="col-md-12 showImage mb-3">
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..."
                                                    class="img-thumbnail">
                                            </div>
                                            <input type="file" name="feature_image" id="image" class="form-control image">
                                            <p id="errfeature_image" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="sliders"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Language **</label>
                                            <select id="language" name="language_id" class="form-control">
                                                <option value="" selected disabled>Select a language</option>
                                                @foreach ($langs as $lang)
                                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                                @endforeach
                                            </select>
                                            <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Status **</label>
                                            <select class="form-control " name="status">
                                                <option value="" selected disabled>Select a status</option>
                                                <option value="1">Show</option>
                                                <option value="0">Hide</option>
                                            </select>
                                            <p id="errstatus" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Title **</label>
                                            <input type="text" class="form-control" name="title" value=""
                                                placeholder="Enter title">
                                            @error('status')
                                            <p id="errtitle" class="mb-0 text-danger em">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">  Price ({{ $be->base_currency_text }})**</label>
                                            <input type="number" class="form-control ltr" name="price" value=""
                                                placeholder="Enter Current Price">
                                            <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> Start Date ({{ $be->base_currency_text }})**</label>
                                            <input type="date" class="form-control ltr" name="start_date" value=""
                                                   placeholder="Enter Current Price">
                                            <p  class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for=""> End Date ({{ $be->base_currency_text }})**</label>
                                                <input type="date" class="form-control ltr" name="end_date" value=""
                                                       placeholder="Enter Current Price">
                                                <p class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Description **</label>
                                            <textarea class="form-control summernote" name="description" placeholder="Enter description"
                                                data-height="300"></textarea>
                                            <p id="errdescription" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@section('variables')--}}
{{--    <script>--}}
{{--        "use strict";--}}
{{--        var storeUrl = "{{ route('admin.offer.sliderstore') }}";--}}
{{--        var removeUrl = "{{ route('admin.offer.sliderrmv') }}";--}}
{{--    </script>--}}
{{--@endsection--}}


{{--@section('vuescripts')--}}
{{--    <script>--}}
{{--        let app = new Vue({--}}
{{--            el: '#app',--}}
{{--            data() {--}}
{{--                return {--}}
{{--                    variants: [],--}}
{{--                    addons: []--}}
{{--                }--}}
{{--            },--}}
{{--            methods: {--}}
{{--                addVariant() {--}}
{{--                    let n = Math.floor(Math.random() * 11);--}}
{{--                    let k = Math.floor(Math.random() * 1000000);--}}
{{--                    let m = String.fromCharCode(n) + k;--}}
{{--                    this.variants.push({--}}
{{--                        uniqid: m,--}}
{{--                        options: []--}}
{{--                    });--}}
{{--                },--}}
{{--                addOption(vKey) {--}}
{{--                    let n = Math.floor(Math.random() * 11);--}}
{{--                    let k = Math.floor(Math.random() * 1000000);--}}
{{--                    let m = String.fromCharCode(n) + k;--}}
{{--                    this.variants[vKey].options.push({--}}
{{--                        uniqid: m,--}}
{{--                        name: '',--}}
{{--                        price: 0--}}
{{--                    });--}}
{{--                },--}}
{{--                removeVariant(index) {--}}
{{--                    this.variants.splice(index, 1);--}}
{{--                },--}}
{{--                removeOption(vIndex, oIndex) {--}}
{{--                    this.variants[vIndex].options.splice(oIndex, 1);--}}
{{--                },--}}
{{--                addAddOn() {--}}
{{--                    let n = Math.floor(Math.random() * 11);--}}
{{--                    let k = Math.floor(Math.random() * 1000000);--}}
{{--                    let m = String.fromCharCode(n) + k;--}}
{{--                    this.addons.push({--}}
{{--                        uniqid: m--}}
{{--                    });--}}
{{--                },--}}
{{--                removeAddOn(index) {--}}
{{--                    this.addons.splice(index, 1);--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
