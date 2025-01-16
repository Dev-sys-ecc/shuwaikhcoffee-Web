@extends('admin.layout')

@if (!empty($data->language) && $data->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }

        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Offer</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-Offer">
                <a href="#">Offers Management</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-Offer">
                <a href="#">Edit Offer</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Offer</div>
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

                            <form id="ajaxForm" class="" action="{{ route('admin.offer.update') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="offer_id" value="{{ $data->id }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="col-12 mb-2">
                                                <label for="image"><strong>Featured Image</strong></label>
                                            </div>
                                            <div class="col-md-12 showImage mb-3">
                                                <img src="{{ $data->image? asset('assets/front/img/offer/featured/' . $data->image): asset('assets/admin/img/noimage.jpg') }}"
                                                    alt="..." class="img-thumbnail">
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
                                            <label for="">Status **</label>
                                            <select class="form-control ltr" name="status">
                                                <option value="" selected disabled>Select a status</option>
                                                <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Show</option>
                                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hide</option>
                                            </select>
                                            <p id="errstatus" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Title **</label>
                                            <input type="text" class="form-control" name="title" placeholder="Enter title"
                                                value="{{ $data->title }}">
                                            <p id="errtitle" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">  Price ({{ $be->base_currency_text }})**</label>
                                            <input type="number" class="form-control ltr" name="price"
                                                value="{{ $data->price }}" placeholder="Enter Current Price">
                                            <p id="errcurrent_price" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> Start Date ({{ $be->base_currency_text }})**</label>
                                            <input type="date" class="form-control ltr" value="{{$data->start_date}}" name="start_date"
                                                   placeholder="Enter Current Price">
                                            <p  class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> End Date ({{ $be->base_currency_text }})**</label>
                                            <input type="date" class="form-control ltr" name="end_date" value="{{$data->end_date}}"
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
                                                data-height="300">{{ replaceBaseUrl($data->description) }}</textarea>
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
                                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

