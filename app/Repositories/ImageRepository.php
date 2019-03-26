<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ImageRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Image';
    }

    public function getImagesInDB($imageIds)
    {
        return $this->model->whereIn('id', $imageIds)->select('id');
    }
}
