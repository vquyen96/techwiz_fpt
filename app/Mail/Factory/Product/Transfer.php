<?php

namespace App\Mail\Factory\Product;

use App\Enums\Alerts\Product\Transfer as AlertProductTransfer;

abstract class Transfer
{
    const DEFAULT_SENDER_ADDRESS = 'no-reply@hblab.vn';
    const DEFAULT_SENDER_NAME = 'RMT';

    public static function buildMailInfo($mailingType)
    {
        $commonInfo = [
            'address' => self::DEFAULT_SENDER_ADDRESS,
            'name' => self::DEFAULT_SENDER_NAME,
        ];

        switch ($mailingType) {
            case AlertProductTransfer::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Seller received this product',
                    'view' => 'emails.product.transfer.accept.buyer.to-buyer'
                ]);
            case AlertProductTransfer::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Winner received this product',
                    'view' => 'emails.product.transfer.accept.seller.to-buyer'
                ]);
            case AlertProductTransfer::TO_BUYER_WITH_BUYER_CANCEL_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Winner unreceived this product',
                    'view' => 'emails.product.transfer.cancel.buyer.to-buyer'
                ]);
            case AlertProductTransfer::TO_SELLER_WITH_BUYER_CANCEL_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Winner unreceived this product',
                    'view' => 'emails.product.transfer.cancel.buyer.to-seller'
                ]);
            case AlertProductTransfer::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Cancel send item by Seller',
                    'view' => 'emails.product.transfer.cancel.seller.to-buyer'
                ]);
            case AlertProductTransfer::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER:
                return array_merge($commonInfo, [
                    'subject' => 'Cancel send item by Seller',
                    'view' => 'emails.product.transfer.cancel.seller.to-seller'
                ]);
            default:
                return $commonInfo;
        }
    }

    public static function buildMailData($product)
    {
        return [
            'product_url' => env('APP_URL') . '/product/' . $product->id,
            'product_name' => $product->title,
            'product_price' => $product->price,
        ];
    }
}
