<?php
namespace App\Helpers;

use App\Enums\Products\ExpirationTime;
use App\Enums\Products\Status as ProductStatus;
use App\Enums\Products\UserType as ProductUserType;
use App\Repositories\ImageRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductHelper
{
    private $imageRepository;

    public function __construct(
        ImageRepository $imageRepository
    ) {
        $this->imageRepository = $imageRepository;
    }

    /**
     * Build product data
     *
     * @param $productData array product data
     *
     * @return array
     */
    public function buildingProductData($productData)
    {
        $now = Carbon::now();

        $defaultValues = [
            'id' => uniqid(),
            'status' => ProductStatus::PUBLISH,
            'published_date' => $now->toDateTimeString(),
            'view_count' => 0,
        ];

        $buildingProductData = $productData;
        $expiration = $buildingProductData['expiration'];
        $bonusDays = ExpirationTime::valueToEnum($expiration);
        $buildingProductData['expired_date'] = $now->addDays($bonusDays)->toDateTimeString();

        return array_merge($buildingProductData, $defaultValues);
    }

    /**
     * Build product transaction data
     *
     * @param $productData array product data
     *
     * @return array
     */
    public function buildingProductTransactionData($productData)
    {
        return [
            'user_id' => $productData['user_id'],
            'product_id' => $productData['id'],
            'status' => ProductStatus::PUBLISH,
        ];
    }

    /**
     * Check images is available in DB
     *
     * @param $imagesData string images id
     *
     * @return array
     */
    public function checkImagesInDB($imagesData)
    {
        $imageIds = explode('|', $imagesData);
        $imagesInDB = $this->imageRepository->getImagesInDB($imageIds)->pluck('id')->all();
        if (count($imagesInDB) < count($imageIds) && count($imagesInDB) !== 0) {
            abort(400);
        }
        return $imagesInDB;
    }

    /**
     * Get product user type
     *
     * @param $product Object of Product
     *
     * @return integer
     */
    public function getProductUserType($product)
    {
        if (Auth::user()) {
            if (Auth::id() === $product->user_id) {
                return ProductUserType::SELLER;
            }

            if (!empty($product->buyer)
                && $product->buyer->user_id === Auth::id()) {
                return ProductUserType::BUYER;
            }
        }

        return ProductUserType::USER;
    }
}
