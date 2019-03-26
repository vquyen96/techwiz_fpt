@extends('admin.layout')

@section('title',  __('locale/user/index.title') )

@section('style')

    <link rel="stylesheet" href="{{ asset('assets/css/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/user/list.css') }}">

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
                                        <a href="{{ route('admin.dashboard') }}"> {{ __('locale/user/index.rmt') }} </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.user.list') }}"> {{ __('locale/user/index.user') }} </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('locale/user/index.all') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="widget has-shadow">
                            <div class="widget-header bordered no-actions d-flex align-items-center">
                                <h4>{{ __('locale/user/index.all_user') }}</h4>
                            </div>
                            <div class="widget-body">
                                <div class="table-responsive">
                                    <form action="">
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group row d-flex align-items-center mb-4 ml-2">
                                                <label class="col-lg-4 form-control-label">{{ __('locale/user/index.item') }}</label>
                                                <div class="col-xl-8 col-lg-8">
                                                    <select name="count" id="" class="form-control">
                                                        <option value="10" {{ isset($_GET['count']) && $_GET['count'] == 10 ? 'selected' : '' }}>10</option>
                                                        <option value="20" {{ !isset($_GET['count']) || $_GET['count'] == 20 ? 'selected' : '' }}>20</option>
                                                        <option value="50" {{ isset($_GET['count']) && $_GET['count'] == 50 ? 'selected' : '' }}>50</option>
                                                        <option value="100" {{ isset($_GET['count']) && $_GET['count'] == 100 ? 'selected' : '' }}>100</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-4 mr-4">
                                                <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                       for="category-title-field">{{ __('locale/user/index.search') }}</label>
                                                <div class="col-xl-7 col-lg-7">
                                                    <input type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                                </div>
                                                <div class="col-xl-3 col-lg-3 form-action">
                                                    <button class="btn btn-gradient-04" type="submit">
                                                        <i class="la la-search"></i> {{ __('locale/user/index.search') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="ml-3">
                                        <?php
                                            $perPage = app('request')->input('count') ?? 20;
                                            $page = app('request')->input('page') ?? 1;
                                            $count = $userList->count();
                                            $total = $userList->total();
                                            $form = $perPage*($page-1)+1;
                                            $to = $perPage*($page-1)+$count;
                                        ?>
                                        {{ __('locale/components/paginate.value_search', ['form' => $form, 'to' => $to, 'total' => $total]) }}
                                    </div>
                                    <table id="user-table" class="table table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="id-field">{{ __('locale/user/index.user_id') }}</th>
                                                <th class="email-field">{{ __('locale/user/index.email') }}</th>
                                                <th>{{ __('locale/user/index.name') }}</th>
                                                <th class="phone-field">{{ __('locale/user/index.created_at') }}</th>
                                                <th class="rate-field">{{ __('locale/user/index.rate') }}</th>
                                                <th class="selled-field">{{ __('locale/user/index.seller') }}</th>
                                                <th class="action-field">{{ __('locale/user/index.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($userList as $user)
                                                <tr>
                                                    <td>
                                                        <span class="text-primary">
                                                            <a href="{{ route('admin.user.detail', $user->id) }}">
                                                                {{ $user->id }}
                                                            </a>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-primary">
                                                            <a href="{{ route('admin.user.detail', $user->id) }}">
                                                                {{ $user->email }}
                                                            </a>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="media">
                                                            <div class="media-left align-self-center mr-3">
                                                                @if($user->avatar_url)
                                                                    <img src="{{ $user->avatar_url }}"
                                                                         class="img-fluid rounded-circle img-w-50">
                                                                @else
                                                                    <img src="{{ asset('assets/img/default-user.png') }}"
                                                                         class="img-fluid rounded-circle img-w-50">
                                                                @endif
                                                            </div>
                                                            <div class="media-body align-self-center">
                                                                <a href="{{ route('admin.user.detail', $user->id) }}">
                                                                {{
                                                                    $userName = $user->name ? $user->name : $user->email,
                                                                    (strlen($userName) > 50) ? substr($userName, 0, 50).' ...' : $userName
                                                                }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ws-nowrap"  data-sort="{{ strtotime($user->created_at) }}">
                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)
                                                        ->timezone(config('view.timezone'))
                                                        ->format('M j Y G:i') }}
                                                    </td>
                                                    <td>{{ $user->rating }}</td>
                                                    <td>{{ $user->products->count() }}</td>
                                                    <td class="td-actions">
                                                        {{--<a href="{{ route('admin.user.detail', $user->id) }}">--}}
                                                            {{--<i class="la la-external-link view"></i>--}}
                                                        {{--</a>--}}
                                                        <a href="{{ route('admin.user.detail', $user->id) . '?target=edit' }}">
                                                            <i class="la la-edit edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        @include('admin.components.paginate-user', ['paginator' => $userList])
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
    <script src="{{ asset('assets/admin/js/user/list.js') }}"></script>

@endsection
