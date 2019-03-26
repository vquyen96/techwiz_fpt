@switch($request_status)
    @case(0)
    <span class="ws-nowrap btn-sm btn-primary">{{ __('locale/components/request-status.open') }}</span>
    @break

    @case(1)
    <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/request-status.closed') }}</span>
    @break
@endswitch
