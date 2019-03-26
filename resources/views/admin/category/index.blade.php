@extends('admin.layout')

@section('title', __('locale/category/index.title'))

@section('style')

    <link rel="stylesheet" href="{{ asset('assets/css/datatables/datatables.min.css') }}">

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
                                        <a href="{{ route('admin.dashboard') }}"> {{ __('locale/category/index.rmt') }} </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.category.list') }}"> {{ __('locale/category/index.category') }}  </a>
                                    </li>
                                    <li class="breadcrumb-item active"> {{ __('locale/category/index.all') }}  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="widget has-shadow">
                            <div class="widget-header bordered no-actions d-flex justify-content-between">
                                <h4>{{ __('locale/category/index.all_category') }}</h4>
                                <div class="widget-options">
                                    <a href="{{ route('admin.category.create') }}"
                                       class="btn btn-gradient-02 mr-1">
                                        <i class="la la-plus"></i> {{ __('locale/category/index.create_new') }}
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <form action="">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group row d-flex align-items-center mb-4 ml-2">
                                            <label class="col-lg-4 form-control-label">{{ __('locale/category/index.item') }} </label>
                                            <div class="col-xl-8 col-lg-8">
                                                <select name="count" id="" class="form-control">
                                                    <option value="10" {{ isset($_GET['count']) && $_GET['count'] == 10 ? 'selected' : '' }}>10</option>
                                                    <option value="20" {{ !isset($_GET['count']) || $_GET['count'] == 20 ? 'selected' : '' }}>20</option>
                                                    <option value="50" {{ isset($_GET['count']) && $_GET['count'] == 50 ? 'selected' : '' }}>50</option>
                                                    <option value="100" {{ isset($_GET['count']) && $_GET['count'] == 100 ? 'selected' : '' }}>100</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-flex align-items-center mb-4 mr-5">
                                            <label class="col-lg-2 form-control-label d-flex justify-content-lg-end"
                                                   for="category-title-field">{{ __('locale/category/index.search') }} </label>
                                            <div class="col-xl-7 col-lg-7">
                                                <input type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                            </div>
                                            <div class="col-xl-3 col-lg-3 form-action">
                                                <button class="btn btn-gradient-04" type="submit">
                                                    <i class="la la-search"></i> {{ __('locale/category/index.search') }}
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                                <div class="ml-3">
                                    <?php
                                    $perPage = app('request')->input('count') ?? 20;
                                    $page = app('request')->input('page') ?? 1;
                                    $count = $categories->count();
                                    $total = $categories->total();
                                    $form = $perPage*($page-1)+1;
                                    $to = $perPage*($page-1)+$count;
                                    ?>
                                    {{--Showing {{ $form }} to {{ $to }} of {{ $total }} entries--}}
                                    {{ __('locale/components/paginate.value_search', ['form' => $form, 'to' => $to, 'total' => $total]) }}
                                </div>
                                <div class="table-responsive">
                                    <table id="product-table" class="table table-bordered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th>{{ __('locale/category/index.category_title') }}</th>
                                            <th>{{ __('locale/category/index.slug') }}</th>
                                            <th>{{ __('locale/category/index.description') }}</th>
                                            <th class="publish-field">{{ __('locale/category/index.created_at') }}</th>
                                            <th class="publish-field sorting_disabled">{{ __('locale/category/index.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.category.edit', $category->id) }}">
                                                        {{ $category->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.category.edit', $category->id) }}">
                                                        {{ $category->slug }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $category->description }}
                                                </td>
                                                <td data-sort="{{ strtotime($category->created_at) }}">
                                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $category->created_at)
                                                    ->timezone(config('view.timezone'))
                                                    ->format('M j Y G:i') }}
                                                </td>
                                                <td class="td-actions d-flex">
                                                    <a href="{{ route('admin.category.edit', $category->id) }}">
                                                        <i class="la la-edit edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        @include('admin.components.paginate-user ', ['paginator' => $categories])
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
    <script src="{{ asset('assets/admin/js/category/list.js') }}"></script>


@endsection
