<?php
namespace App\Helpers;

use App\Repositories\PaypalPaymentRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentHelper
{
    private $paymentRepository;
    private $userRepository;
    private $productRepository;

    public function __construct(
        PaypalPaymentRepository $paymentRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function decreaseFiningCancelCount($sellerId)
    {
        $this->userRepository->decreaseFiningCancelCount($sellerId);
    }

    public function getProductSalePayment($productId, $userId)
    {
        return $this->paymentRepository->findWhere([
            'product_id' => $productId,
            'user_id' => $userId,
            'resource_type' => 'sale',
        ])->last();
    }

    public function computeTransferAmount($payment, $productId, $seller)
    {
        $finingCancelFee = $seller->cancel_fining_count > 0 ? config('paypal.cancel_fining_fee') : 0;
        $rmtFee = config('paypal.rmt_fee');
        $productPrice = $this->productRepository->find($productId, ['buy_now_price'])->buy_now_price;
        $amountAfterFee = $productPrice * (1 - $rmtFee - $finingCancelFee);
        return [
            'amount_total' => $amountAfterFee,
            'amount_currency' => $payment->currency,
        ];
    }

    public function generatePaypalPaymentData($jsonData)
    {
        $eventType = $jsonData['event_type'] ?? "null";

        if (strpos($eventType, "PAYMENT.SALE") === 0) {
            return $this->generatePaypalSaleData($jsonData);
        } elseif (strpos($eventType, "PAYMENT.PAYOUT") === 0) {
            return $this->generatePaypalPayoutData($jsonData);
        } else {
            return null;
        }
    }

    private function generatePaypalSaleData($jsonData)
    {
        $clearTimeData = $jsonData['resource']['clearing_time'] ?? null;
        $clearTime = $clearTimeData !== null ? (
            Carbon::parse($clearTimeData)->format("Y-m-d H:i:s")
        ) : null;

        $saleId = $jsonData['resource']['sale_id'] ?? null;
        $customData = $jsonData['resource']['custom'] ?? null;
        $customDataJson = json_decode($customData, 1);
        $productId = $customDataJson['productId'] ?? null;
        $userId = $customDataJson['userId'] ?? null;

        return [
            'event_id' => $jsonData['id'],
            'action_type' => $jsonData['event_type'],
            'resource_type' => $jsonData['resource_type'],
            'summary' => $jsonData['summary'],
            'parent_payment' => $jsonData['resource']['parent_payment'],
            'transaction_id' => $jsonData['resource']['id'],
            'payment_mode' => $jsonData['resource']['payment_mode'] ?? '',
            'amount_total' => $jsonData['resource']['amount']['total'],
            'currency' => $jsonData['resource']['amount']['currency'],
            'state' => $jsonData['resource']['state'],
            'paid_create_time' => Carbon::parse($jsonData['create_time'])->format("Y-m-d H:i:s"),
            'transaction_create_time' => Carbon::parse($jsonData['resource']['create_time'])->format("Y-m-d H:i:s"),
            'transaction_clear_time' => $clearTime,
            'product_id' => $productId,
            'user_id' => $userId,
            'sale_id' => $saleId,
            'total_fee' => $jsonData['resource']['transaction_fee']['value'] ?? 0.00,
            'total_fee_currency' => $jsonData['resource']['transaction_fee']['currency'] ?? '',
        ];
    }

    private function generatePaypalPayoutData($jsonData)
    {
        $payoutItemData = $jsonData['resource']['payout_item'] ?? null;
        $noteData = $payoutItemData['note'] ?? null;
        $noteataJson = json_decode($noteData, 1);
        $productId = $noteataJson['productId'] ?? null;
        $userId = $noteataJson['userId'] ?? null;
        return [
            'event_id' => $jsonData['id'],
            'action_type' => $jsonData['event_type'],
            'resource_type' => $jsonData['resource_type'],
            'summary' => $jsonData['summary'],
            'transaction_id' => $jsonData['resource']['transaction_id'],
            'amount_total' => $jsonData['resource']['payout_item']['amount']['value'],
            'currency' => $jsonData['resource']['payout_item']['amount']['currency'],
            'paid_create_time' => Carbon::parse($jsonData['create_time'])->format("Y-m-d H:i:s"),
            'state' => $jsonData['resource']['transaction_status'],
            'total_fee' => $jsonData['resource']['payout_item_fee']['value'] ?? 0.00,
            'total_fee_currency' => $jsonData['resource']['payout_item_fee']['currency'] ?? '',
            'product_id' => $productId,
            'user_id' => $userId,
        ];
    }

    public function writePaymentReceivingLog($jsonData)
    {
        $eventType = $jsonData['event_type'] ?? "null";
        $transactionId = $jsonData['resource']['id'] ?? "null";
        $amount = $jsonData['resource']['amount']['total'] ?? "null";
        $currency = $jsonData['resource']['amount']['currency'] ?? "null";

        Log::info(
            "================PAYPAL PAYMENT==============\n".
            "Event Type: ".$eventType."\n".
            "Transaction ID: ".$transactionId."\n".
            "Amount: ".$amount."\n".
            "Currency: ".$currency."\n".
            "=============================="
        );
    }
}
