@switch($product_status)
    @case(0)
        <span class="ws-nowrap btn-sm btn-secondary">{{ __('locale/components/product-status.draft') }}</span>
    @break
    @case(1)
        <span class="ws-nowrap btn-sm btn-primary">{{ __('locale/components/product-status.publish') }}</span>
    @break
    @case(2)
        <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/product-status.waiting') }}</span>
    @break
    @case(3)
        <span class="ws-nowrap btn-sm btn-success">{{ __('locale/components/product-status.selling_success') }}</span>
    @break
    @case(4)
        <span class="ws-nowrap btn-sm btn-success">{{ __('locale/components/product-status.buyer_received_item') }}</span>
    @break
    @case(5)
        <span class="ws-nowrap btn-sm btn-danger">{{ __('locale/components/product-status.stop_selling') }}</span>
    @break
    @case(6)
        <span class="ws-nowrap btn-sm btn-danger">{{ __('locale/components/product-status.cancel') }}</span>
    @break
@endswitch
