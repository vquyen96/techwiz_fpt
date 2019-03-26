<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductServiceInterface;
use App\Http\Requests\Product\PublishProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\GetDetailProductRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @group Product
 */
class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
 
    /**
     * Publish-Product
     * Publish New Product
     *
     * @param PublishProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam title string required Title of product
     * @bodyParam game_id integer required id of the game that product belongs to
     * @bodyParam delivery_method integer required delivery type
     * @bodyParam buy_now_price decimal required buy now price
     * @bodyParam expiration integer required expiration days: 1 day, 7 days,...
     *
     * @response {
     *   "product": {
     *      "title": "Wow wow",
     *      "game_id": 1,
     *      "description": "Good for your life",
     *      "delivery_method": 0,
     *      "buy_now_price": 500,
     *      "status": 0,
     *      "user_id": 1
     *   }
     * }
     */
    public function publish(PublishProductRequest $request)
    {
        $imagesData = $request->input('images');
        $productData = $request->only([
            'title',
            'game_id',
            'description',
            'delivery_method',
            'buy_now_price',
            'expiration',
        ]);
        
        $authUser = Auth::user();
        
        if ($authUser->paypal_email === null) {
            return response()->json([
                'message' => 'Paypal account required'
            ], 402);
        }

        $productData['user_id'] = $authUser->id;
        $responseData = $this->productService->publish($productData, $imagesData);
        return response()->json($responseData, 201);
    }

    /**
     * Edit-Product
     * Edit Product
     *
     * @param EditProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam id integer required Id of product
     * @bodyParam title string required Title of product
     * @bodyParam game_id integer required id of the game that product belongs to
     * @bodyParam delivery_method integer required delivery type
     * @bodyParam buy_now_price decimal required buy now price
     * @bodyParam expiration integer required expiration days: 1 day, 7 days,...
     *
     * @response {
     *   "product": "5c36b5a1e9891"
     * }
     */
    public function edit(EditProductRequest $request)
    {
        $productId = $request->input('id');
        $imagesData = $request->input('images');
        $productData = $request->only([
            'title',
            'game_id',
            'description',
            'delivery_method',
            'buy_now_price',
            'expiration',
        ]);

        $productData['user_id'] = Auth::id();
        $responseData = $this->productService->edit($productId, $productData, $imagesData);
        return response()->json($responseData, 201);
    }

    /**
     * Get-Latest-Product
     * Get Latest Product by paging.
     *
     * @param Request $request
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "products": [
     *      {
     *          "id": "5bceaa5139012",
     *          "title": "Wow wow",
     *          "game_id": 1,
     *          "description": "Good for your life",
     *          "delivery_method": 0,
     *          "view_count": 0,
     *          "user_id": 1,
     *          "published_date": "2018-10-23 04:57:53",
     *          "buy_now_price": "500.00",
     *          "expired_date": "2018-10-23 04:57:53",
     *          "status": 0
     *      }
     *     ]
     *  }
     */
    public function getNew(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $responseData = $this->productService->getNew($perPage);
        return response()->json($responseData, 200);
    }

    /**
     * Product basic detail
     * Get product basic details
     *
     * @param GetDetailProductRequest $request
     * @queryParam id required integer number for id of product
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *      "id": "1",
     *      "title": "Super boot",
     *      "game_id": 1,
     *      "description": "Đồ Hiếm",
     *      "delivery_method": 1,
     *      "buy_now_price": "200000.00",
     *      "expired_date": "2019-01-28 04:11:30",
     *      "expiration": 11,
     *      "status": 1,
     *      "published_date": "2019-01-28 04:11:30",
     *      "user_id": 1,
     *      "view_count": 1,
     *      "current_user_type": 1,
     *      "images": [
     *              {
     *                  "id": 1,
     *                  "url": "https://aws.hblab.co.jp/test1.jpg"
     *              },
     *              {
     *                  "id": 2,
     *                  "url": "https://aws.hblab.co.jp/test2.jpg"
     *              }
     *          ],
     *      "user": {
     *          "id": 1,
     *          "name": "RMT Admin",
     *          "email": "admin@rmt.com",
     *          "description": "",
     *          "avatar_bucket": "",
     *          "avatar_name": "",
     *          "avatar_url": "",
     *          "role": 1,
     *          "tel": "",
     *          "rating": 0,
     *          "review_count": 0,
     *          "paypal_email": "123@gmail.com",
     *          "verified": 1,
     *          "remember_token": "123",
     *          "created_at": "2019-01-28 04:11:29",
     *          "updated_at": "2019-01-28 04:11:29"
     *      },
     *      "buyer": 1
     * }
     */
    public function show(GetDetailProductRequest $request)
    {
        $responseData = $this->productService->getDetail($request->input('id'));
        return response()->json($responseData, 200);
    }

    /**
     * Get-Listing-Product
     * Get listing Product by paging.
     *
     * @param Request $request
     * @queryParam status required integer number for status of product
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "products": [
     *      {
     *          "id": 1,
     *          "title": "Wow wow",
     *          "game_id": 1,
     *          "description": "Good for your life",
     *          "delivery_method": 0,
     *          "view_count": 0,
     *          "buy_now_price" : "220000.00",
     *          "product_status": 0,
     *          "buying_status": 0,
     *          "published_date": "2018-10-23 04:57:53",
     *          "created_at": "2019-01-28 04:11:30",
     *          "expired_date": "2018-10-23 04:57:53",
     *          "images": [
     *              {
     *                  "id": 1,
     *                  "url": "https://aws.hblab.co.jp/test1.jpg"
     *              },
     *              {
     *                  "id": 2,
     *                  "url": "https://aws.hblab.co.jp/test2.jpg"
     *              }
     *          ]
     *      }
     *     ],
     *   "current_page" : 1,
     *   "total_page" : 3
     *  }
     */
    public function listing(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $status = $request->query('status') ?? 0;
        $responseData = $this->productService->getListing($status, $perPage);
        return response()->json($responseData, 200);
    }

    /**
     * Get-Purchase-Product-List
     * Get Purchase Product List by paging.
     *
     * @param Request $request
     * @queryParam status required integer number for status of product
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "products": [
     *      {
     *          "id": 1,
     *          "title": "Wow wow",
     *          "game_id": 1,
     *          "description": "Good for your life",
     *          "delivery_method": 0,
     *          "view_count": 0,
     *          "buy_now_price" : "220000.00",
     *          "product_status": 0,
     *          "buying_status": 0,
     *          "published_date": "2018-10-23 04:57:53",
     *          "created_at": "2019-01-28 04:11:30",
     *          "expired_date": "2018-10-23 04:57:53",
     *          "images": [
     *              {
     *                  "id": 1,
     *                  "url": "https://aws.hblab.co.jp/test1.jpg"
     *              },
     *              {
     *                  "id": 2,
     *                  "url": "https://aws.hblab.co.jp/test2.jpg"
     *              }
     *          ]
     *      }
     *     ],
     *   "current_page" : 1,
     *   "total_page" : 3
     *  }
     */
    public function purchase(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $status = $request->query('status') ?? 0;
        $responseData = $this->productService->getPurchase($status, $perPage);
        return response()->json($responseData, 200);
    }

    /**
     * ReOpen Product Expired
     *
     * @queryParam id required integer number for id of product
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "products": [
     *      {
     *          "id": "5c873d149eb3d",
     *          "title": "Hello",
     *          "game_id": 1,
     *          "description": "1212121212",
     *          "delivery_method": 2,
     *          "buy_now_price": "20.00",
     *          "expired_date": "2019-03-25 04:55:40",
     *          "expiration": 6,
     *          "status": 1,
     *          "published_date": "2019-03-19 04:55:40",
     *          "user_id": "5c87354005405",
     *          "view_count": 0,
     *          "created_at": "2019-03-12 05:01:08",
     *          "updated_at": "2019-03-19 04:55:40"
     *      }
     *     ]
     *  }
     */
    public function reOpen($id)
    {
        $responseData = $this->productService->reOpen($id);
        return response()->json($responseData, 200);
    }
}
