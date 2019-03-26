<?php


namespace App\Services;

use App\Enums\Alerts\Product\Transfer as ProductTransfer;
use App\Enums\Products\Status as ProductStatus;
use App\Enums\Transactions\Buying as TransactionBuyingStatus;
use App\Repositories\BuyingRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use App\Repositories\ReviewingRepository;
use App\Repositories\UserRepository;
use App\Services\PaypalPaymentServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductTransferService implements ProductTransferServiceInterface
{
    private $buyingRepository;
    private $alertService;
    private $productRepository;
    private $productTransactionRepository;
    private $reviewingRepository;
    private $userRepository;
    private $paymentService;

    public function __construct(
        BuyingRepository $buyingRepository,
        AlertServiceInterface $alertService,
        ProductRepository $productRepository,
        ProductTransactionRepository $productTransactionRepository,
        ReviewingRepository $reviewingRepository,
        UserRepository $userRepository,
        PaypalPaymentServiceInterface $paymentService
    ) {
        $this->buyingRepository = $buyingRepository;
        $this->alertService = $alertService;
        $this->productRepository = $productRepository;
        $this->productTransactionRepository = $productTransactionRepository;
        $this->reviewingRepository = $reviewingRepository;
        $this->userRepository = $userRepository;
        $this->paymentService = $paymentService;
    }

    /**
     * Product transfer accept
     *
     * @param $productId integer required id of product
     *
     * @return null
     */
    public function acceptProduct($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->status === ProductStatus::SELLING_SUCCESS
            && $product->buyer->user_id === Auth::id()) {
            return $this->handleBuyerReceive($product);
        }

        abort(403, 'Your request was rejected');
    }

    protected function handleBuyerReceive($product)
    {
        DB::transaction(function () use ($product) {
            $this->buyingRepository->update([
                'status' => TransactionBuyingStatus::TRANSACTION_COMPLETED
            ], $product->buyer->id);

            $this->productRepository->update([
                'status' => ProductStatus::BUYER_RECEIVED
            ], $product->id);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::BUYER_RECEIVED,
            ]);

            $this->reviewingRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'reviewer_id' => $product->buyer->user_id,
            ]);

            $this->reviewingRepository->create([
                'user_id' => $product->buyer->user_id,
                'product_id' => $product->id,
                'reviewer_id' => $product->user_id,
            ]);
        });

        $this->sendAlertBuyerReceive($product);

        $this->paymentService->transferToSeller(
            $product->id,
            $product->buyer->user_id
        );

        return ['status' => ProductStatus::BUYER_RECEIVED];
    }

    /**
     * Product transfer cancel
     *
     * @param $productId integer required id of product
     *
     * @return null
     */
    public function cancelProduct($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->status === ProductStatus::SELLING_SUCCESS
            && $product->buyer->user_id === Auth::id()) {
            $this->handleBuyerCancel($product);
            return [
                'status' => ProductStatus::CANCEL,
                'cancel_status' => TransactionBuyingStatus::BUYER_CANCEL_TRANSFER
            ];
        }

        if ($product->status === ProductStatus::SELLING_SUCCESS
            && $product->user_id === Auth::id()) {
            $this->handleSellerCancel($product);
            $this->paymentService->handlePaymentRefund($product->id, $product->buyer->user_id);
            return [
                'status' => ProductStatus::CANCEL,
                'cancel_status' => TransactionBuyingStatus::SELLER_CANCEL_TRANSFER
            ];
        }

        abort(403, 'Your request was rejected');
    }

    private function handleBuyerCancel($product)
    {
        DB::transaction(function () use ($product) {
            $this->productRepository->update([
                'status' => ProductStatus::CANCEL
            ], $product->id);

            $this->buyingRepository->update([
                'status' => TransactionBuyingStatus::BUYER_CANCEL_TRANSFER
            ], $product->buyer->id);

            $this->reviewingRepository->create([
                'user_id' => $product->buyer->user_id,
                'product_id' => $product->id,
                'reviewer_id' => $product->user_id,
            ]);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::CANCEL,
            ]);
        });

        $this->sendAlertBuyerCancel($product);
    }

    private function handleSellerCancel($product)
    {
        DB::transaction(function () use ($product) {
            $this->productRepository->update([
                'status' => ProductStatus::CANCEL
            ], $product->id);

            $this->buyingRepository->update([
                'status' => TransactionBuyingStatus::SELLER_CANCEL_TRANSFER
            ], $product->buyer->id);

            $this->reviewingRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'reviewer_id' => $product->buyer->user_id,
            ]);

            $this->productTransactionRepository->create([
                'user_id' => $product->user_id,
                'product_id' => $product->id,
                'status' => ProductStatus::CANCEL,
            ]);

            $seller = $this->userRepository->find($product->user_id);
            $seller->increment('cancel_fining_count');
        });

        $this->sendAlertSellerCancel($product);
    }

    protected function sendAlertSellerCancel($product)
    {
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_BUYER_WITH_SELLER_CANCEL_TRANSFER
        );
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_SELLER_WITH_SELLER_CANCEL_TRANSFER
        );
    }

    protected function sendAlertBuyerCancel($product)
    {
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_BUYER_WITH_BUYER_CANCEL_TRANSFER
        );
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_SELLER_WITH_BUYER_CANCEL_TRANSFER
        );
    }

    private function sendAlertBuyerReceive($product)
    {
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_BUYER_WITH_BUYER_RECEIVED_TRANSFER
        );
        $this->alertService->sendProductTransferAlert(
            $product,
            ProductTransfer::TO_SELLER_WITH_BUYER_RECEIVED_TRANSFER
        );
    }
}
