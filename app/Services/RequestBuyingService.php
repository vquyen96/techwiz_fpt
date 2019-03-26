<?php

namespace App\Services;

use App\Repositories\RequestRepository;
use App\Helpers\ProductHelper;
use App\Enums\Request\Status as RequestStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Enums\Products\ExpirationTime;
use Carbon\Carbon;

class RequestBuyingService implements RequestBuyingServiceInterface
{
    private $requestRepository;
    private $productHelper;

    public function __construct(
        RequestRepository $requestRepository,
        ProductHelper $productHelper
    ) {
        $this->requestRepository = $requestRepository;
        $this->productHelper = $productHelper;
    }

    public function create($requestData, $imagesData)
    {
        $authUser = Auth::user();

        $expiration = $requestData['expiration'];
        $bonusDays = ExpirationTime::valueToEnum($expiration);

        $requestBuying = array_merge(
            $requestData,
            [
                'id' => uniqid(),
                'status' => RequestStatus::OPEN,
                'user_id' => $authUser->id,
                'expired_date' => Carbon::now()->addDays($bonusDays)->toDateTimeString(),
            ]
        );
        
        $images = $this->productHelper->checkImagesInDB($imagesData);

        return DB::transaction(function () use ($requestBuying, $images) {
            $createdRequest = $this->requestRepository->create($requestBuying);
            $createdRequest->images()->attach($images);

            return $createdRequest;
        });
    }

    public function showDetail($id)
    {
        $requestDetail = $this->requestRepository
                            ->with([
                                'images',
                                'user:name,avatar_url,id,created_at,rating,review_count'
                            ])->find($id);

        if (!isset($requestDetail)) {
            abort(404);
        }

        $requestDetail->is_owner = $requestDetail->user_id == Auth::id();

        return [
            'request_buying' => $requestDetail,
        ];
    }

    public function stopRequest($id)
    {
        $requestDetail = $this->requestRepository->find($id);
        
        if (!isset($requestDetail)) {
            abort(404);
        }

        if (Auth::id() != $requestDetail->user_id) {
            abort(403);
        }

        $requestDetail->update([
            'status' => RequestStatus::CLOSED,
        ]);

        return $requestDetail;
    }

    public function update($requestId, $requestData, $imagesData)
    {
        $requestDetail = $this->requestRepository->find($requestId);

        if (!isset($requestDetail)) {
            abort(404);
        }

        if ($requestDetail->user_id != Auth::id()) {
            abort(403);
        }

        $images = $this->productHelper->checkImagesInDB($imagesData);
        
        DB::transaction(function () use ($requestDetail, $requestData, $images) {
            $requestDetail->update($requestData);
            $requestDetail->images()->detach();
            $requestDetail->images()->attach($images);
        });

        return $requestDetail->with(['images'])->get();
    }

    public function listing($status, $perPage)
    {
        $requests = $this->requestRepository
        ->with(['images'])
        ->getListingRequest($status, $perPage);
 
        return [
            'requests' => $requests->all(),
            'total_page' => $requests->total(),
        ];
    }
    
    public function myRequests($status, $perPage)
    {
        $requests = $this->requestRepository
                            ->with(['images'])
                            ->myRequests($status, $perPage);
        
        return [
            'requests' => $requests->all(),
            'total_page' => $requests->total(),
        ];
    }
}
