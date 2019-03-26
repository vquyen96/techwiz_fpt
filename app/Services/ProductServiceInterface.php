<?php

namespace App\Services;

interface ProductServiceInterface
{
    public function getNew($perPage);
    public function getDetail($id);
    public function getListing($status, $perPage);
    public function getPurchase($status, $perPage);
    public function publish($productData, $imagesData);
    public function getSeller($productId);
    public function reOpen($id);
}
