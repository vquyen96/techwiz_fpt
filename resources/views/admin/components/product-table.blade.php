<div class="table-responsive">
    <table class="table mb-0 user-product-table">
        <thead>
            <tr>
                <th>{{ __('locale/components/product-table.title') }}</th>
                <th class="publish-field">{{ __('locale/components/product-table.publish') }}</th>
                <th class="status-field">{{ __('locale/components/product-table.status') }}</th>
                <th>{{ __('locale/components/product-table.price') }}</th>
                <th class="action-field">{{ __('locale/components/product-table.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productList as $product)
                <tr>
                    <td>
                        <div class="media">
                            <div class="media-left align-self-center mr-3">
                                @if( isset($product->images) && $product->images->first())
                                    <img src="{{ array_first($product->images)->thumbnail_url }}"
                                         style="width: 50px;" class="img-fluid" alt="{{ $product->title }}">
                                @else
                                    <img src="{{ asset('assets/img/default-image.png') }}"
                                         style="width: 50px;" class="img-fluid" alt="{{ $product->title }}">
                                @endif
                            </div>
                            <div class="media-body align-self-center">
                                {{ (strlen($product->title) > 100) ? substr($product->title, 0, 100).' ...' : $product->title }}
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($product->published_date)->format('M j Y G:i')}}
                    </td>
                    <td>
                        @productStatus(['product_status' => $product->status])
                        @endproductStatus
                    </td>
                    <td>$ {{ $product->buy_now_price }}</td>
                    <td class="td-actions">
                        <a href="{{ route('admin.product.detail', $product->id) }}">
                            <i class="la la-external-link view"></i>
                        </a>
                        <a href="{{ route('admin.product.edit', $product->id) }}">
                            <i class="la la-edit edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
