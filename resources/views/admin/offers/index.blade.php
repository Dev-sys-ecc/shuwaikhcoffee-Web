@extends('admin.layout')

@php
$selLang = App\Models\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Items</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
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
        <a href="#">Offers</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Offers</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('admin.offer.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Offer</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.offer.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($offers) == 0)
                <h3 class="text-center">NO OFFER FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Offer Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Price (KD)</th>
                        <th scope="col">Start_Date</th>
                        <th scope="col">End_Date</th>
                        <th scope="col">Status</th>
                        <th scope="col" width="15%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($offers as $key => $offer)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$offer->id}}">
                          </td>
                          <td><img src="{{asset('assets/front/img/offer/featured/'.$offer->image)}}" width="80"></td>
                          <td>{{convertUtf8(strlen($offer->title)) > 200 ? convertUtf8(substr($offer->title, 0, 200)) . '...' : convertUtf8($offer->title)}}</td>
                          <td>{{$offer->price}}</td>
                            <td>{{$offer->start_date}}</td>
                            <td>{{$offer->end_date}}</td>
                            <td>
                                <form id="statusForm{{$offer->id}}" action="{{route('admin.offer.feature')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="offer_id" value="{{$offer->id}}">
                                    <select name="status" id="" class="form-control-sm text-white
                                  @if($offer->status == 1)
                                  bg-success
                                  @elseif ($offer->status == 0)
                                  bg-danger
                                  @endif
                                " onchange="document.getElementById('statusForm{{$offer->id}}').submit();">
                                        <option value="1" {{$offer->status == 1 ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{$offer->status == 0 ? 'selected' : ''}}>No</option>
                                    </select>
                                </form>
                            </td>
                          <td width="15%">
                            <a class="btn btn-secondary btn-sm p-2" href="{{route('admin.offer.edit', $offer->id) . '?language=' . request()->input('language')}}">
                              <i class="fas fa-edit"></i>
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.offer.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="offer_id" value="{{$offer->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn p-2">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
