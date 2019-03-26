@extends('admin.layout')

@section('title',  __('locale/user/show.title') )

@section('style')

    <link rel="stylesheet" href="{{ asset('assets/css/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/user/show.css') }}">

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
                                        <a href="{{ route('admin.dashboard') }}"> {{ __('locale/user/show.rmt') }} </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.user.list') }}"> {{ __('locale/user/show.user') }} </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('locale/user/show.user_detail') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row flex-row">
                    <div class="col-xl-3">
                        <div class="widget has-shadow">
                            <div class="widget-body">
                                <div class="mt-5">
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}"
                                             class="avatar rounded-circle d-block mx-auto img-w-120">
                                    @else
                                        <img src="{{ asset('assets/img/default-user.png') }}"
                                             class="avatar rounded-circle d-block mx-auto img-w-120">
                                    @endif
                                </div>
                                @if($user->name)
                                    <h3 class="text-center mt-3 mb-1">{{ $user->name }}</h3>
                                    <p class="text-center mb-1">{{ $user->email }}</p>
                                @else
                                    <h3 class="text-center mt-3 mb-1">{{ $user->email }}</h3>
                                @endif
                                @if($user->paypal_email)
                                    <p class="text-center mb-1">
                                        {{ __('locale/user/show.paypal_email') }} : {{ $user->paypal_email }}
                                    </p>
                                @endif
                                <p class="text-center">{{ $user->tel }}</p>
                                <h3 class="text-center mt-3 mb-1">{{ $user->rating }} / 5.0</h3>
                                <div class="user-rate mb-3">
                                    @rateStar(['rate' => $user->rating]) @endrateStar
                                </div>
                                <p>{{ $user->description }}</p>
                                <div class="em-separator separator-dashed"></div>
                                <ul class="nav flex-column" role="tablist" id="user-detail-sidebar">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errors->isEmpty() && !$isEdit ? 'active' : '' }}"
                                            id="user-detail-base-selling-product"
                                            data-toggle="tab" href="#user-detail-selling-product" role="tab"
                                            aria-controls="user-detail-selling-product"
                                            aria-selected="{{ $errors->isEmpty() && !$isEdit ? 'true' : 'false' }}">
                                            <i class="la la-sign-out la-2x align-middle pr-2"></i> {{ __('locale/user/show.selling') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="user-detail-base-buying-product"
                                            data-toggle="tab" href="#user-detail-buying-product" role="tab"
                                            aria-controls="user-detail-buying-product" aria-selected="false">
                                            <i class="la la-sign-in la-2x align-middle pr-2"></i> {{ __('locale/user/show.buying') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="user-detail-base-ticket"
                                            data-toggle="tab" href="#user-detail-ticket" role="tab"
                                            aria-controls="user-detail-ticket" aria-selected="false">
                                            <i class="la la-comments la-2x align-middle pr-2"></i> {{ __('locale/user/show.ticket') }}
                                        </a>
                                    </li>
                                    <li class="em-separator separator-dashed"></li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $errors->isEmpty() && !$isEdit ? '' : 'active' }}"
                                            id="user-detail-base-edit-information"
                                            data-toggle="tab" href="#user-detail-edit-information" role="tab"
                                            aria-controls="user-detail-edit-information"
                                            aria-selected="{{ $errors->isEmpty() && !$isEdit ? 'false' : 'true' }}">
                                            <i class="la la-pencil la-2x align-middle pr-2"></i> {{ __('locale/user/show.edit') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="widget has-shadow">
                            <div class="tab-content">
                                <div class="tab-pane fade {{ $errors->isEmpty() && !$isEdit ? 'show active' : '' }}"
                                    id="user-detail-selling-product" role="tabpanel"
                                    aria-labelledby="user-detail-base-selling-product">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>{{ __('locale/user/show.selling') }}</h4>
                                    </div>
                                    <div class="widget-body">
                                        @productTable(['productList' => $user->products]) @endproductTable
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-detail-buying-product" role="tabpanel"
                                    aria-labelledby="user-detail-base-buying-product">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>{{ __('locale/user/show.buyig') }}</h4>
                                    </div>
                                    <div class="widget-body">
                                        @productTable(['productList' => $buyings]) @endproductTable
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="user-detail-ticket" role="tabpanel"
                                     aria-labelledby="user-detail-base-ticket">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>{{ __('locale/user/show.ticket') }}</h4>
                                    </div>
                                    <div class="widget-body">

                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $errors->isEmpty() && !$isEdit ? '' : 'show active' }}"
                                    id="user-detail-edit-information" role="tabpanel"
                                    aria-labelledby="user-detail-base-edit-information">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>{{ __('locale/user/show.edit') }}</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="col-10 ml-auto">
                                            <div class="section-title mt-3 mb-3">
                                                <h4>{{ __('locale/user/show.basic_information') }}</h4>
                                            </div>
                                        </div>
                                        <form class="form-horizontal" method="post"
                                              action="{{ route('admin.user.update', $user->id) }}">
                                            @csrf
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label for="user-edit-name-field"
                                                       class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.name') }}
                                                </label>
                                                <div class="col-xl-8 col-lg-10">
                                                    <input id="user-edit-name-field" type="text" name="name"
                                                           class="form-control" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label for="user-edit-email-field"
                                                       class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.email') }}
                                                </label>
                                                <div class="col-xl-8 col-lg-10">
                                                    <input id="user-edit-email-field" type="text" name="email" disabled
                                                           class="form-control" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.status') }}
                                                </label>
                                                <div class="col-xl-8 col-lg-10">
                                                    @if($user->verified == 1)
                                                        <span class="btn btn-sm btn-success">{{ __('locale/user/show.verified') }}</span>
                                                    @else
                                                        <span class="btn btn-sm btn-warning">{{ __('locale/user/show.pending_verified') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label for="user-edit-phone-field"
                                                       class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.phone') }}
                                                </label>
                                                <div class="col-xl-8 col-lg-10">
                                                    <input id="user-edit-phone-field" name="tel"
                                                           type="text" class="form-control" value="{{ $user->tel }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label for="user-edit-paypal-field"
                                                       class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.paypal_account') }}</label>
                                                <div class="col-xl-8 col-lg-10">
                                                    <input type="text" id="user-edit-paypal-field" name="paypal_email"
                                                           disabled class="form-control" value="{{ $user->paypal_email }}">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label for="user-edit-description-field"
                                                       class="col-lg-2 form-control-label d-flex justify-content-lg-end">
                                                    {{ __('locale/user/show.description') }}
                                                </label>
                                                <div class="col-xl-8 col-lg-10">
                                                    <textarea class="form-control" rows="10" name="description"
                                                              id="user-edit-description-field" required>{{ $user->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="em-separator separator-dashed"></div>
                                            <div class="text-right">
                                                <button class="btn btn-gradient-01" type="submit">
                                                    {{ __('locale/user/show.save') }}
                                                </button>
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

    <script src="{{ asset('assets/vendors/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/user/show.js') }}"></script>

@endsection
