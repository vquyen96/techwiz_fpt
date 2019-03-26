@switch($ticket_status)
    @case(0)
    <span class="ws-nowrap btn-sm btn-primary">{{ __('locale/components/ticket-status.created') }}</span>
    @break

    @case(1)
    <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/ticket-status.in_progess') }}</span>
    @break

    @case(2)
    <span class="ws-nowrap btn-sm btn-success">{{ __('locale/components/ticket-status.solved') }}</span>
    @break

    @case(3)
    <span class="ws-nowrap btn-sm btn-secondary">{{ __('locale/components/ticket-status.closed') }}</span>
    @break
@endswitch
