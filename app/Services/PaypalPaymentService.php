<?php

namespace App\Services;

use App\Helpers\PaymentHelper;
use App\Repositories\PaypalPaymentRepository;
use App\Services\AlertServiceInterface;
use App\Models\Product;
use PayPal\Api\Sale;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Refund;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\VerifyWebhookSignature;
use Illuminate\Http\Request;

class PaypalPaymentService implements PaypalPaymentServiceInterface
{
    private $paypalPaymentRepository;
    private $productConfirmService;
    private $alertService;
    private $paymentHelper;
    private $productService;
    private $apiContext;

    public function __construct(
        PaypalPaymentRepository $paypalPaymentRepository,
        AlertServiceInterface $alertService,
        ProductConfirmServiceInterface $productConfirmService,
        PaymentHelper $paymentHelper,
        ProductServiceInterface $productService
    ) {
        $this->setupContext();
        $this->paypalPaymentRepository = $paypalPaymentRepository;
        $this->alertService = $alertService;
        $this->productConfirmService = $productConfirmService;
        $this->paymentHelper = $paymentHelper;
        $this->productService = $productService;
    }

    private function setupContext()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret'))
        );
        $this->apiContext->setConfig(config('paypal'));
    }

    public function savePaypalPayment($jsonData)
    {
        $this->paymentHelper->writePaymentReceivingLog($jsonData);
        $paypalData = $this->paymentHelper->generatePaypalPaymentData($jsonData);
        $this->paypalPaymentRepository->create($paypalData);
    }

    public function handlePaymentSaleCompleted($paymentData)
    {
        if ($paymentData['event_type'] !== 'PAYMENT.SALE.COMPLETED') {
            return;
        }

        if (!array_key_exists('custom', $paymentData['resource'])) {
            abort(400);
        }

        $customDataJson = json_decode($paymentData['resource']['custom'] ?? null, 1) ?? null;
        if ($customDataJson === null) {
            abort(500);
        }

        $productId = $customDataJson['productId'] ?? null;
        $userId = $customDataJson['userId'] ?? null;

        $this->productConfirmService->handleSellingSuccess($productId, $userId, $paymentData);
    }

    public function handlePaymentRefund($productId, $buyerId)
    {
        $foundPayment = $this->paymentHelper->getProductSalePayment($productId, $buyerId);

        if ($foundPayment === null) {
            abort(404);
        }

        $transactionId = $foundPayment->transaction_id;

        $sale = new Sale();
        $sale->setId($transactionId);

        try {
            $sale->refundSale(new Refund(), $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            abort(500);
        } catch (Exception $ex) {
            abort(500);
        }
    }

    public function transferToSeller($productId, $buyerId)
    {
        $validatedPayment = $this->paymentHelper->getProductSalePayment($productId, $buyerId);
        $seller = $this->productService->getSeller($productId);
        $transferAmount = $this->paymentHelper->computeTransferAmount($validatedPayment, $productId, $seller);

        $transferMessage = 'You received a transfer for your Product from RMT system!';
        $payouts = $this->transferPaypalAccount(
            $seller->paypal_email,
            $transferMessage,
            $productId,
            $buyerId,
            $transferAmount
        );

        try {
            $payouts->create(null, $this->apiContext);
        } catch (Exception $ex) {
            abort(500);
        }

        $this->decreaseFiningCount($productId);
    }

    /**
     * docs: https://github.com/paypal/PayPal-PHP-SDK/blob/master/sample/payouts/CreateBatchPayout.php
     *
     * @return void
     */
    public function transferPaypalAccount($receiverEmail, $message, $productId, $buyerId, $amount)
    {
        $payouts = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
                            ->setEmailSubject("Receive from RMT system!");
        $parsingAmount = [
            "value" => $amount['amount_total'],
            'currency' => $amount['amount_currency'],
        ];
        $noteData = [
            'userId' => $buyerId,
            'productId' => $productId
        ];
        $senderItem = new PayoutItem(
            array(
                'recipient_type' => 'EMAIL',
                'receiver' => $receiverEmail,
                'note' => $message,
                'sender_item_id' => $productId,
                'amount' => $parsingAmount,
                'note' => json_encode($noteData),
            )
        );
        
        $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);
        return $payouts;
    }

    public function decreaseFiningCount($productId)
    {
        $sellerId = $this->productService->getSeller($productId)->id;
        return $this->paymentHelper->decreaseFiningCancelCount($sellerId);
    }

    /**
     * docs: http://paypal.github.io/PayPal-PHP-SDK/sample/doc/notifications/ValidateWebhookEvent.html
     *
     * @param Request $request
     * @return boolean
     */
    public function isWebHookRequestValidated(Request $request)
    {
        $requestBody = $request->getContent();
        $headers = $request->headers->all();
        $headers = array_change_key_case($headers, CASE_UPPER);

        $exceptionLogFile = storage_path('logs/paypal-exception.log');

        try {
            $signatureVerification = new VerifyWebhookSignature();
            $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO'][0]);
            $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID'][0]);
            $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL'][0]);
            $signatureVerification->setWebhookId(config('paypal.webhooks.webhook_id'));
            $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG'][0]);
            $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME'][0]);

            $signatureVerification->setRequestBody($requestBody);
            $request = clone $signatureVerification;
        
            /** @var \PayPal\Api\VerifyWebhookSignatureResponse $output */
            $output = $signatureVerification->post($this->apiContext);
            $status = $output->getVerificationStatus();
            return strtoupper($status) === 'SUCCESS';
        } catch (\Exception $ex) {
            file_put_contents($exceptionLogFile, $ex->getMessage().PHP_EOL, FILE_APPEND);
            return false;
        }
    }
}
