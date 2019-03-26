<?php

namespace App\Http\Controllers\API;

use App\Services\LocationServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationServiceInterface $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        $responseData = $this->locationService->getAll();
        return response()->json($responseData, 200);
    }
}
