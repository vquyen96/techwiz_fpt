<?php

namespace App\Services;

interface RequestBuyingServiceInterface
{
    public function create($requestData, $imagesData);
    public function showDetail($id);
    public function stopRequest($id);
    public function update($requestId, $requestData, $imagesData);
    public function listing($status, $perPage);
    public function myRequests($status, $perPage);
}
