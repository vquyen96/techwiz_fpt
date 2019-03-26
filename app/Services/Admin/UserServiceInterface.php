<?php

namespace App\Services\Admin;

interface UserServiceInterface
{
    public function getList($count, $search);
    public function getDetail($id);
    public function updateUser($productData, $productId);
}
