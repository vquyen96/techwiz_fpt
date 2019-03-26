<?php

namespace App\Http\Controllers\API;

use App\Services\Admin\FeeServiceInterface;
use App\Http\Controllers\Controller;

/**
 * @group Fee
 */
class FeeController extends Controller
{
    protected $feeService;

    public function __construct(FeeServiceInterface $feeService)
    {
        $this->feeService = $feeService;
    }

    /**
     * Get Fee
     *
     * @return \Illuminate\Http\JsonResponse
     * @response
     * {
     *      "fee" : "9.69"
     * }
     */
    public function index()
    {
        $feeValue = $this->feeService->valueOrDefaultTransactionFee();
        if ($feeValue == null) {
            $this->index();
        }
        $responseData = [
            'fee' => $feeValue
        ];
        return response()->json($responseData, 200);
    }
}
