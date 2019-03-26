@extends('admin.layout')

@section('title', __('locale/category/edit.title'))

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
                                        <a href="{{ route('admin.dashboard') }}"> {{ __('locale/category/edit.rmt') }} </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.product.list') }}"> {{ __('locale/category/edit.category') }} </a>
                                    </li>
                                    <li class="breadcrumb-item active"> {{ __('locale/category/edit.edit') }} </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row flex-row">
                    <div class="col-xl-12">
                        <div class="widget widget-07 has-shadow">
                            <div class="widget-header bordered d-flex align-items-center">
                                <h2>{{ __('locale/category/edit.category_edit') }}</h2>
                            </div>
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="col-10 ml-auto">
                                            <div class="section-title mt-4 mb-5">
                                                <h4>{{ __('locale/category/edit.category_information') }}</h4>
                                            </div>
                                        </div>
                                        <form class="form-horizontal"
                                              action="{{ route('admin.category.update', Request::segment(3)) }}"
                                              method="post"
                                              id="form_category">
                                            {{method_field('PUT')}}
                                            @csrf
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"
                                                       for="product-title-field">{{ __('locale/category/edit.slug') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <input type="text"
                                                           class="form-control" name="slug" value="{{ $category->slug }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"
                                                       for="product-seller-field">{{ __('locale/category/edit.title_en') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <input type="text"
                                                           class="form-control" name="title_en" value="{{ $category->title_en }}">
                                                    <input type="text" class="d-none" name="id_en" value="{{ $category->id_en }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"
                                                       for="product-description-field">{{ __('locale/category/edit.description_en') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <textarea class="form-control" name="description_en" rows="10"
                                                              >{!! $category->description_en !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"
                                                           for="product-seller-field">{{ __('locale/category/edit.title_ja') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <input type="text"
                                                           class="form-control" name="title_ja"  value="{{ $category->title_ja }}">
                                                    <input type="text" class="d-none" name="id_ja" value="{{ $category->id_ja }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"
                                                       for="product-description-field">{{ __('locale/category/edit.description_ja') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <textarea class="form-control" name="description_ja" rows="10"
                                                              >{!! $category->description_ja !!}</textarea>
                                                </div>
                                            </div>

                                            <div class="em-separator separator-dashed"></div>
                                            <div class="row d-flex">
                                                <div class="col-xl-12">
                                                    <div class="form-action float-right">
                                                        <a href="{{ route('admin.category.list') }}"
                                                           class="btn btn-gradient-02 mr-2">
                                                            <i class="la la-close"></i> {{ __('locale/category/edit.cancel') }}
                                                        </a>
                                                        <button class="btn btn-gradient-04" type="submit" disabled>
                                                            <i class="la la-save"></i> {{ __('locale/category/edit.update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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

    <script src="{{ asset('assets/vendors/js/lity/lity.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/product/show.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/category/form.js') }}"></script>

@endsection
