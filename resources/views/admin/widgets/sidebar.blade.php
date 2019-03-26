<div class="default-sidebar">
    <nav class="side-navbar box-scroll sidebar-scroll">
        <ul class="list-unstyled">
            {{--<li class="{{ Request::is('admin') ? 'active' : '' }}">--}}
                {{--<a href="{{ route('admin.dashboard') }}">--}}
                    {{--<i class="la la-columns"></i><span>Dashboard</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="{{ Request::is('admin/users/*')
                || Request::is('admin/users') ? 'active' : '' }}">
                <a href="{{ route('admin.user.list') }}">
                    <i class="la la-user" title="{{ __('locale/widgets/sidebar.user') }}"></i><span>{{ __('locale/widgets/sidebar.user') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/products/*')
                || Request::is('admin/products') ? 'active' : '' }}">
                <a href="{{ route('admin.product.list') }}">
                    <i class="la la-cubes" title="{{ __('locale/widgets/sidebar.product') }}"></i><span>{{ __('locale/widgets/sidebar.product') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/ticket/*')
                || Request::is('admin/ticket') ? 'active' : '' }}">
                <a href="{{ route('admin.ticket.list') }}">
                    <i class="la la-ticket" title="{{ __('locale/widgets/sidebar.ticket') }}"></i><span>{{ __('locale/widgets/sidebar.ticket') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/ticket_question/*')
                || Request::is('admin/ticket_question') ? 'active' : '' }}">
                <a href="{{ route('admin.ticket_question.list') }}">
                    <i class="la la-question" title="{{ __('locale/widgets/sidebar.ticket_question') }}"></i><span>{{ __('locale/widgets/sidebar.ticket_question') }}</span>
                </a>
            </li>            <li class="{{ Request::is('admin/category/*')
                || Request::is('admin/category') ? 'active' : '' }}">
                <a href="{{ route('admin.category.list') }}">
                    <i class="la la-list" title="{{ __('locale/widgets/sidebar.category') }}"></i><span>{{ __('locale/widgets/sidebar.category') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/game/*')
                || Request::is('admin/game') ? 'active' : '' }}">
                <a href="{{ route('admin.game.list') }}">
                    <i class="la la-gamepad" title="{{ __('locale/widgets/sidebar.game') }}"></i><span>{{ __('locale/widgets/sidebar.game') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/request-buying/*')
                || Request::is('admin/request-buying') ? 'active' : '' }}">
                <a href="{{ route('admin.request_buying.index') }}">
                    <i class="la la-pencil" title="{{ __('locale/widgets/sidebar.request_buying') }}"></i><span>{{ __('locale/widgets/sidebar.request_buying') }}</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/setting') ? 'active' : '' }}">
                <a href="{{ route('admin.system.setting') }}">
                    <i class="la la-gear" title="{{ __('locale/widgets/sidebar.setting') }}"></i><span>{{ __('locale/widgets/sidebar.setting') }}</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
