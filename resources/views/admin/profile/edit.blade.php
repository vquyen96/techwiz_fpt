@extends('admin.layout')

@section('title', __('locale/profile/edit.title'))

@section('style')

    <link rel="stylesheet" href="{{ asset('assets/css/lity/lity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/product/show.css') }}">

@endsection

@section('content')

    @include('admin.widgets.header')

    <div class="page-content d-flex align-items-stretch">

        @include('admin.widgets.sidebar')

        <div class="content-inner">
            <!-- Begin Dashboard Content -->
            <div class="container-fluid full-scr-height">
                <div class="row">
                    <div class="page-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}"> {{ __('locale/profile/edit.rmt') }} </a>
                                    </li>
                                    <li class="breadcrumb-item active"> {{ __('locale/profile/edit.profile') }} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row flex-row">
                    <div class="col-xl-12">
                        <div class="widget widget-07 has-shadow">
                            <div class="widget-header bordered d-flex align-items-center">
                                <h2>{{ __('locale/profile/edit.profile_edit') }}</h2>
                            </div>
                            <div class="widget-body">
                                <form class="form-horizontal"
                                      action="{{ route('admin.profile.update', $profile->id) }}"
                                      method="post"
                                      enctype="multipart/form-data"
                                      id="form_profile">
                                    {{method_field('PUT')}}
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <input type="file" class="d-none" name="image" onchange="changeImg(this)">
                                            <img src="{{ $profile->avatar_url ? $profile->avatar_url : asset('assets/img/add-image.png') }}" alt="" class="changeImg w-100 img-thumbnail">
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="col-10 ml-auto">
                                                <div class="section-title mt-4 mb-5">
                                                    <h4>{{ __('locale/profile/edit.profile_information') }}</h4>
                                                </div>
                                            </div>

                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                       for="product-seller-field">{{ __('locale/profile/edit.name') }}</label>
                                                <div class="col-xl-10 col-lg-10">
                                                    <input type="text" id="product-seller-field"
                                                           class="form-control" name="name" required value="{{ $profile->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                       for="product-seller-field">{{ __('locale/profile/edit.email') }}</label>
                                                <div class="col-xl-10 col-lg-10">
                                                    <input type="text" id="product-seller-field"
                                                           class="form-control" required value="{{ $profile->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                       for="product-seller-field">{{ __('locale/profile/edit.phone') }}</label>
                                                <div class="col-xl-10 col-lg-10">
                                                    <input type="text" id="product-seller-field"
                                                           class="form-control" name="tel" value="{{ $profile->tel }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                       for="product-description-field">{{ __('locale/profile/edit.description') }}</label>
                                                <div class="col-xl-10 col-lg-10">
                                                        <textarea class="form-control" name="description" rows="10"
                                                                  id="product-description-field">{{ $profile->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="em-separator separator-dashed"></div>
                                            <div class="row d-flex">
                                                <div class="col-xl-12">
                                                    <div class="form-action float-right">
                                                        <a href="{{ route('admin.category.list') }}"
                                                           class="btn btn-gradient-02 mr-2">
                                                            <i class="la la-close"></i> {{ __('locale/profile/edit.cancel') }}
                                                        </a>
                                                        <button class="btn btn-gradient-04" type="submit">
                                                            <i class="la la-save"></i> {{ __('locale/profile/edit.save') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Dashboard Content -->

            @include('admin.widgets.footer')

            <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/product/show.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/profile/form.js') }}"></script>
    <script src="{{ asset('assets/admin/js/ticket/show.js') }}"></script>
@endsection
