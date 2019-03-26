@switch($status)
    @case(App\Enums\Transactions\Buying::SELLING_SUCCESS)
        <span class="ws-nowrap btn-sm btn-primary">{{ __('locale/components/product-transaction-status.selling_success') }}</span>
        @break
    @case(App\Enums\Transactions\Buying::SELLER_CANCEL_TRANSFER)
        <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/product-transaction-status.seller_cancel') }}</span>
    @break
    @case(App\Enums\Transactions\Buying::BUYER_CANCEL_TRANSFER)
        <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/product-transaction-status.buyer_cancel') }}</span>
    @break
    @case(App\Enums\Transactions\Buying::TRANSACTION_COMPLETED)
        <span class="ws-nowrap btn-sm btn-warning">{{ __('locale/components/product-transaction-status.complete') }}</span>
    @break
@endswitch
