<?php

namespace App\Services;

use App\Enums\Alerts\Product\Confirm as ProductConfirm;
use App\Enums\Products\Status as ProductStatus;
use App\Enums\Transactions\Buying as TransactionBuyingStatus;
use App\Enums\Alerts\Payment\Payment as PaymentStatus;
use App\Repositories\BuyingRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use App\Repositories\ReviewingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductConfirmService implements ProductConfirmServiceInterface
{
    private $buyingRepository;
    private $alertService;
    private $productRepository;
    private $productTransactionRepository;
    
    public function __construct(
        BuyingRepository $buyingRepository,
        AlertServiceInterface $alertService,
        ProductRepository $productRepository,
        ProductTransactionRepository $productTransactionRepository
    ) {
        $this->buyingRepository = $buyingRepository;
        $this->alertService = $alertService;
        $this->productRepository = $productRepository;
        $this->productTransactionRepository = $productTransactionRepository;
    }

    public function handleSellingSuccess($productId, $buyerId, $paymentData)
    {
        $product = $this->productRepository->find($productId);

        DB::transaction(function () use ($product, $buyerId) {
            $this->productRepository->update([
                'status' => ProductStatus::SELLING_SUCCESS
            ], $product->id);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::SELLING_SUCCESS,
            ]);

            $this->buyingRepository->create([
                'product_id' => $product->id,
                'user_id' => $buyerId,
                'price' => $product->buy_now_price,
                'status' => TransactionBuyingStatus::SELLING_SUCCESS
            ]);
        });

        $this->alertService->sendPaymentAlert(
            $product,
            $paymentData,
            PaymentStatus::TO_BUYER_WITH_BUYER_TRANSFER_MONEY
        );

        $this->alertService->sendPaymentAlert(
            $product,
            $paymentData,
            PaymentStatus::TO_SELLER_WITH_BUYER_TRANSFER_MONEY
        );
    }

    public function cancelProduct($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->status !== ProductStatus::PUBLISH
        || $product->user_id !== Auth::id()) {
            abort(403, 'Your request was rejected');
        }

        return $this->handleSellerStopSelling($product);
    }
    
    public function transferMoney($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->status !== ProductStatus::PUBLISH) {
            abort(409);
        }

        return $this->handleBuyerTransferMoney($product);
    }

    private function handleBuyerTransferMoney($product)
    {
        DB::transaction(function () use ($product) {
            $this->productRepository->update([
                'status' => ProductStatus::WAITING_SYSTEM_RECEIVE_MONEY
            ], $product->id);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::WAITING_SYSTEM_RECEIVE_MONEY,
            ]);
        });

        return ['status' => ProductStatus::WAITING_SYSTEM_RECEIVE_MONEY];
    }

    private function handleSellerStopSelling($product)
    {
        DB::transaction(function () use ($product) {
            $this->productRepository->update([
                'status' => ProductStatus::STOP_SELLING
            ], $product->id);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::STOP_SELLING,
            ]);
        });

        return ['status' => ProductStatus::STOP_SELLING];
    }
}
