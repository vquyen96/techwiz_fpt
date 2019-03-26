<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Repositories\ReviewingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewService implements ReviewServiceInterface
{
    private $reviewRepository;
    private $userRepository;
    private $reviewingRepository;

    public function __construct(
        ReviewRepository $reviewRepository,
        UserRepository $userRepository,
        ReviewingRepository $reviewingRepository
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
        $this->reviewingRepository = $reviewingRepository;
    }

    public function create($reviewData)
    {
        $reviewingUserId = $reviewData['user_id'];
        $reviewingUser = $this->userRepository->find($reviewingUserId);
        $reviewerId = Auth::id();

        $reviewable = $this->reviewingRepository
                        ->getFirstReviewable($reviewingUserId, $reviewerId);

        if (!isset($reviewable)) {
            abort(403);
        }

        $copyReviewData = $reviewData;
        $copyReviewData['reviewer_id'] = $reviewerId;

        $rating = $reviewData['rating'];

        $createdData = DB::transaction(function () use (
            $copyReviewData,
            $reviewable,
            $rating,
            $reviewingUserId,
            $reviewingUser
        ) {
            $this->userRepository->updateRating($reviewingUserId, $rating);
            $createdReview = $this->reviewRepository->create($copyReviewData);
            $this->reviewingRepository->delete($reviewable->id);

            $this->userRepository->update([
                'review_count' => $reviewingUser->review_count + 1,
            ], $reviewingUser->id);

            return $createdReview;
        });
        
        return [
            'review' => [
                'id' => $createdData->id,
                'user_id' => $createdData->user_id,
                'rating' => $createdData->rating,
                'content' => $createdData->content,
                'reviewer_id' => $createdData->reviewer_id,
            ],
        ];
    }

    public function getReviews($id, $perPage, $filter)
    {
        $selectedFields = [
            'reviews.id',
            'reviews.reviewer_id',
            'users.name',
            'users.avatar_url',
            'reviews.rating',
            'reviews.content',
            'reviews.created_at',
        ];

        $user = $this->userRepository->find($id);
        if (empty($user)) {
            abort(404);
        }

        $review = $this->reviewRepository->getReviews($id, $perPage, $filter, $selectedFields);
        $reviewedEmotional = $this->userRepository->reviewedEmotional($id);
        $avgRating = $this->userRepository->find($id, ['rating'])->rating;

        return [
            'reviews' => $review,
            'reviewed_emotional' => $reviewedEmotional,
            'average_rating' => $avgRating
        ];
    }
}
