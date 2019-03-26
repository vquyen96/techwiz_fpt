<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductConfirmServiceInterface;

/**
 * @group Product
 */
class ProductConfirmController extends Controller
{
    private $productConfirmService;

    public function __construct(
        ProductConfirmServiceInterface $productConfirmService
    ) {
        $this->productConfirmService = $productConfirmService;
    }

    /**
     * Transfer Money Status
     *
     * @param Request $request
     * @queryParam id required string id of product
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *     "status": 2
     *  }
     */
    public function transferMoney(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:products'
        ]);

        $responseData = $this->productConfirmService
                            ->transferMoney($validatedData['id']);
        return response()->json($responseData, 200);
    }

    /**
     * Stop selling product
     *
     * @param Request $request
     * @queryParam id required string id of product
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *     "status": 5
     *  }
     */
    public function cancel(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:products'
        ]);

        $responseData = $this->productConfirmService
                            ->cancelProduct($validatedData['id']);
        return response()->json($responseData, 200);
    }
}
