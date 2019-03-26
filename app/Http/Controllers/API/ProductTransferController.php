<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTransfer\CancelRequest;
use App\Http\Requests\ProductTransfer\TransferRequest;
use App\Services\ProductTransferServiceInterface;

class ProductTransferController extends Controller
{
    protected $productTransferService;

    public function __construct(
        ProductTransferServiceInterface $productTransferService
    ) {
        $this->productTransferService = $productTransferService;
    }

    /**
     * Accept product transaction
     *
     * @param TransferRequest $request
     * @queryParam id required integer id of product
     * @queryParam type required integer type of transaction
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *     'status': 5
     *  }
     */
    public function accept(TransferRequest $request)
    {
        $responseData = $this->productTransferService->acceptProduct($request->input('id'));
        return response()->json($responseData, 200);
    }

    /**
     * Cancel transfer item
     *
     * @param CancelRequest $request
     * @queryParam id required string id of product
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *     'status': 7
     * }
     */
    public function cancel(CancelRequest $request)
    {
        $responseData = $this->productTransferService->cancelProduct($request->input('id'));
        return response()->json($responseData, 200);
    }
}
