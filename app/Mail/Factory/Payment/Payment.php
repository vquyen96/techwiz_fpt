<?php

namespace App\Mail\Factory\Payment;

use App\Enums\Alerts\Payment\Payment as AlertPayment;

abstract class Payment
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
            case AlertPayment::TO_BUYER_WITH_BUYER_TRANSFER_MONEY:
                return array_merge($commonInfo, [
                    'subject' => 'Transfer money successfully',
                    'view' => 'emails.payment.receive.to-buyer'
                ]);
            case AlertPayment::TO_SELLER_WITH_BUYER_TRANSFER_MONEY:
                return array_merge($commonInfo, [
                    'subject' => 'Buyer sent money to purchase your item',
                    'view' => 'emails.payment.receive.to-seller'
                ]);
            case AlertPayment::TO_SELLER_WITH_RMT_TRANSFER_MONEY:
                return array_merge($commonInfo, [
                    'subject' => 'Congratulation! Your money is coming',
                    'view' => 'emails.payment.transfer.to-seller'
                ]);
            case AlertPayment::TO_BUYER_WITH_RMT_REFUND_MONEY:
                return array_merge($commonInfo, [
                    'subject' => 'Your money is coming back',
                    'view' => 'emails.payment.refund.to-buyer'
                ]);
            case AlertPayment::TO_SELLER_WITH_RMT_REFUND_MONEY:
                return array_merge($commonInfo, [
                    'subject' => 'Your money is coming back',
                    'view' => 'emails.payment.refund.to-seller'
                ]);
            default:
                return $commonInfo;
        }
    }

    public static function buildMailData($product, $transferAmount, $mailingType)
    {
        $commonData = [
            'product_url' => env('APP_URL') . '/product/' . $product->id,
            'product_name' => $product->title,
            'amount' => $transferAmount,
        ];

        switch ($mailingType) {
            case AlertPayment::TO_BUYER_WITH_BUYER_TRANSFER_MONEY:
            case AlertPayment::TO_BUYER_WITH_RMT_REFUND_MONEY:
                return array_merge($commonData, [
                    'product_price' => $product->buy_now_price
                ]);
            case AlertPayment::TO_SELLER_WITH_RMT_TRANSFER_MONEY:
            case AlertPayment::TO_SELLER_WITH_BUYER_TRANSFER_MONEY:
            case AlertPayment::TO_SELLER_WITH_RMT_REFUND_MONEY:
                return array_merge($commonData, [
                    'product_price' => $product->buy_now_price,
                    'buyer_name' => $product->buyer->user->name
                ]);
            default:
                return $commonData;
        }
    }
}
