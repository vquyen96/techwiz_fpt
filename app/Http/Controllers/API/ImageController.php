<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ImageServiceInterface;
use App\Http\Requests\Image\UploadImageRequest;

/**
 * @group Image
 */
class ImageController extends Controller
{

    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Upload-Image
     * Upload new image to AWS S3
     *
     * @param $request UploadImageRequest
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam image file required
     *
     * @response {
     *   "image": {
     *     "id": 1
     *     "title": "good-for-you",
     *     "thumbnail_url": "https://hblab-rmt.s3.ap-northeast-1.amazonaws.com/41b21c21bc99.jpeg",
     *     "picture_url": "https://hblab-rmt.s3.ap-northeast-1.amazonaws.com/picture-89acad204aed.jpeg",
     *   }
     * }
     */
    public function store(UploadImageRequest $request)
    {
        $image = $this->imageService->store($request->file('image'));
        return response()->json($image, 201);
    }
}
