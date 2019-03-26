<?php

namespace App\Services;

use App\Repositories\ImageRepository;

class ImageService implements ImageServiceInterface
{
    protected $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function store($file)
    {
        $resizeImages = $this->resize($file);
        $s3Data = $this->uploadToS3($resizeImages);
        $s3Data['title'] = $this->slug($file->getClientOriginalName());
        $image = $this->insertIntoDB($s3Data);

        return [
            'id' => $image->id,
            'title' => $image->title,
            'thumbnail_url' => $image->thumbnail_url,
            'picture_url' => $image->picture_url,
        ];
    }

    protected function resize($file)
    {
        return [
            'thumbnail' => \Image::make($file)->fit(300),
            'picture' => \Image::make($file)->fit(640),
        ];
    }

    protected function uploadToS3($imageData)
    {
        $thumbnailImage = $this->uploadImage('thumbnail', $imageData['thumbnail']);
        $pictureImage = $this->uploadImage('picture', $imageData['picture']);

        return [
            'thumbnail_bucket' => $thumbnailImage['bucket'],
            'thumbnail_name'   => $thumbnailImage['name'],
            'thumbnail_url' => $thumbnailImage['url'],
            'picture_bucket' => $pictureImage['bucket'],
            'picture_name' => $pictureImage['name'],
            'picture_url' => $pictureImage['url'],
        ];
    }

    protected function uploadImage($type, $image)
    {
        $imageMime = $this->getImageMime($image);
        $imageName = $type . '-' . uniqid() . '.' . $imageMime;
        \Storage::disk('s3')->put($imageName, $image->stream()->__toString());
        $imageUrl = \Storage::disk('s3')->url($imageName);

        return [
            'bucket' => env('AWS_BUCKET'),
            'name' => $imageName,
            'url' => $imageUrl,
        ];
    }

    protected function getImageMime($image)
    {
        return explode('/', $image->mime)[1];
    }

    protected function insertIntoDB($s3Data)
    {
        return $this->imageRepository->create($s3Data);
    }

    protected function slug($string)
    {
        $string = pathinfo($string, PATHINFO_FILENAME);
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-zA-Z0-9-]/', '-', $string);

        return preg_replace('/-+/', "-", $string);
    }
}
