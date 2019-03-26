<?php

namespace App\Services\Admin;

use App\Enums\User\Role;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function getList($count, $search)
    {
        return $this->userRepository
            ->searchList($search)
            ->where('role', Role::USER)
            ->paginate($count);
    }

    public function getDetail($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user || $user->role !== Role::USER) {
            abort(404);
        }

        return $user;
    }

    public function updateUser($productData, $productId)
    {
        return $this->userRepository->update($productData, $productId);
    }

    public function getPurchase($userId)
    {
        return $this->userRepository->getPurchase($userId);
    }
}
