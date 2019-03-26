<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\BuyingRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewingRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Support\Facades\Auth;
use App\Enums\Transactions\Buying;
use Illuminate\Support\Facades\Hash;
use App\Enums\Products\Status as ProductStatus;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $buyingRepository;
    private $productRepository;
    private $reviewingRepository;
    private $reviewRepository;

    public function __construct(
        UserRepository $userRepository,
        BuyingRepository $buyingRepository,
        ProductRepository $productRepository,
        ReviewingRepository $reviewingRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->userRepository = $userRepository;
        $this->buyingRepository = $buyingRepository;
        $this->productRepository = $productRepository;
        $this->reviewingRepository = $reviewingRepository;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Get User Info
     *
     * @param $id
     * @return array
     */
    public function getUserInfo($id)
    {
        $selectedField = [
            'id',
            'name',
            'avatar_url',
            'description',
            'rating',
            'created_at',
            'paypal_email'
        ];
        $user = $this->userRepository->find($id, $selectedField);

        if (empty($user)) {
            abort(404);
        }

        $buyingCount = $this->buyingRepository->findWhere([
            'user_id' => $id,
            'status' => Buying::TRANSACTION_COMPLETED
        ])->count();
        $sellingCount = $this->productRepository->findWhere([
            'user_id' => $id,
            'status' => ProductStatus::BUYER_RECEIVED
        ])->count();
        
        $reviewable = $this->isUserReviewable($user->id);
        $reviewedCount = $this->reviewRepository->findWhere([
            'user_id' => $id,
        ])->count();
        $reviewedEmotional = $this->userRepository->reviewedEmotional($id);

        return [
            'user' => $user,
            'buying_count' => $buyingCount,
            'selling_count' => $sellingCount,
            'reviewed_count' => $reviewedCount,
            'reviewable' => $reviewable,
            'reviewed_emotional' => $reviewedEmotional,
        ];
    }

    /**
     * Undocumented function
     *
     * @param unsigned_integer $id
     * @return boolean
     */
    private function isUserReviewable($id)
    {
        if (Auth::id() === $id) {
            return false;
        }

        return $this->reviewingRepository
            ->numberRemainingReview($id, Auth::id()) > 0;
    }

    public function updatePaypalEmail($paypalEmail)
    {
        $user = Auth::user();
        $user->update(['paypal_email' => $paypalEmail]);

        return $user;
    }

    public function update($userData)
    {
        $userId = Auth::id();
        $this->userRepository->update($userData, $userId);
        return $this->userRepository->find($userId);
    }

    public function changePassword($currentPassword, $newPassword)
    {
        $authUser = Auth::user();
        $matchingPassword = Hash::check($currentPassword, $authUser->password);

        if ($matchingPassword === false) {
            abort(400, 'password not matching');
        }

        $this->userRepository->update([
            'password' => Hash::make($newPassword)
        ], $authUser->id);
    }

    public function publicProducts($userId, $perPage)
    {
        return $this->userRepository->publicProducts($userId, $perPage);
    }
}
