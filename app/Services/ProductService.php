<?php

namespace App\Services;

use App\Helpers\ProductHelper;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Enums\Products\Status;

class ProductService implements ProductServiceInterface
{
    private $productHelper;
    private $productRepository;
    private $productTransactionRepository;

    public function __construct(
        ProductHelper $productHelper,
        ProductRepository $productRepository,
        ProductTransactionRepository $productTransactionRepository
    ) {
        $this->productHelper = $productHelper;
        $this->productRepository = $productRepository;
        $this->productTransactionRepository = $productTransactionRepository;
    }

    /**
     * Publish Product
     *
     * @param $productData
     * @param $imagesData
     * @return array saved product
     */
    public function publish($productData, $imagesData)
    {
        $buildingProductData = $this->productHelper
            ->buildingProductData($productData);
        $productTransactionData = $this->productHelper
            ->buildingProductTransactionData($buildingProductData);
        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);

        DB::transaction(function () use ($buildingProductData, $productTransactionData, $imagesInDB) {
            $product = $this->productRepository->create($buildingProductData);
            $product->images()->attach($imagesInDB);
            $this->productTransactionRepository->create($productTransactionData);
        });

        return [
            'product' => $buildingProductData,
            'product_transaction' => $productTransactionData,
        ];
    }

    /**
     * Edit Product
     *
     * @param $productId
     * @param $productData
     * @param $imagesData
     * @return array saved product
     */
    public function edit($productId, $productData, $imagesData)
    {
        $product = $this->productRepository->find($productId);
        if (is_null($product) || $product['user_id'] != Auth::id()) {
            abort(403, 'Your request was rejected');
        }
        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);

        DB::transaction(function () use ($product, $productData, $imagesInDB) {
            $publishedDate = Carbon::parse($product['published_date']);
            $this->productRepository->update([
                'title' => $productData['title'],
                'game_id' => $productData['game_id'],
                'description' => $productData['description'],
                'delivery_method' => $productData['delivery_method'],
                'buy_now_price' => $productData['buy_now_price'],
                'expiration' => $productData['expiration'],
                'expired_date' => $publishedDate->addDays($productData['expiration'])->toDateTimeString()
            ], $product->id);
            $product->images()->detach();
            $product->images()->attach($imagesInDB);
        });

        return [
            'productId' => $productId
        ];
    }

    /**
     * Get Latest Product
     *
     * @param $perPage
     * @return array latest product list
     */
    public function getNew($perPage)
    {
        $selectedFields = [
            'id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'user_id',
            'published_date',
            'buy_now_price',
            'expired_date',
            'status'
        ];

        $products = $this->productRepository
            ->with(['images'])
            ->getNew($perPage, 'published_date', $selectedFields)
            ->all();

        return [
            'products' => $products,
        ];
    }

    /**
     * Get Product detail
     *
     * @param $id string product id
     * @return array product detail
     */
    public function getDetail($id)
    {
        $selectedFields = [
            'id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'buy_now_price',
            'expired_date',
            'expiration',
            'status',
            'published_date',
            'user_id',
            'view_count',
        ];

        $responseData = $this->productRepository->with([
            'images',
            'user:name,avatar_url,id,created_at,rating,review_count',
            'buyer.user:name,avatar_url,id,created_at,rating,review_count'
            ])
            ->find($id, $selectedFields);
        $responseData->current_user_type = $this->productHelper->getProductUserType($responseData);
        return $responseData;
    }

    /**
     * Get listing
     *
     * @param $status
     * @param $perPage
     * @return array listing product
     */
    public function getListing($status, $perPage)
    {
        $statusArray = explode('|', $status);
        $userId = Auth::id();
        $products = $this->productRepository
            ->with(['images'])
            ->getListing($userId, $statusArray, $perPage)->toArray();

        return [
            'products' => $products['data'],
            'current_page' => $products['current_page'],
            'total_page' => $products['last_page']
        ];
    }

    /**
     * Get purchase list
     * @param $status
     * @param $perPage
     * @return array listing product
     */
    public function getPurchase($status, $perPage)
    {
        $statusArray = explode("|", $status);
        $userId = Auth::id();
        $products = $this->productRepository
            ->with(['images'])
            ->getPurchase($userId, $statusArray, $perPage)
            ->toArray();
        return [
            'products' => $products['data'],
            'current_page' => $products['current_page'],
            'total_page' => $products['last_page']
        ];
    }


    public function getSeller($productId)
    {
        $seller = $this->productRepository->find($productId)->user;
        return isset($seller) ? $seller : abort(404);
    }

    public function reOpen($id)
    {
        $timeNow = Carbon::now();
        $product = $this->productRepository->find($id);
        if ($product->user_id != Auth::id()) {
            abort(403, 'Your request was rejected');
        }
        if ($product->status != Status::STOP_SELLING) {
            abort(403, 'Product status not match');
        }

        $product->update([
            'published_date' => $timeNow->toDateTimeString(),
            'status' => Status::PUBLISH,
            'expired_date' => $timeNow->addDays($product->expiration)->toDateTimeString()
            ]);
        return [
            'product' => $product
        ];
    }
}
