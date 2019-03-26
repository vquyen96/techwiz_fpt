<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public function model()
    {
        return 'App\Models\User';
    }

    public function updateRating($id, $newRating)
    {
        $currentUser = $this->model->find($id);
        $reviews = $currentUser->reviews;
        $totalStarRating = $reviews->sum('rating');
        $numberRating = $reviews->count();

        $averageRating = ($totalStarRating + $newRating) / ($numberRating + 1);

        $currentUser->update(['rating' => $averageRating]);
    }

    public function updatePassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }

    public function searchList($search)
    {
        $userSearch = $this->model;
        if (isset($search)) {
            $userSearch = $userSearch->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('tel', 'like', '%'.$search.'%');
            });
        }
        return $userSearch;
    }

    public function getPurchase($id)
    {
        $buyingIds = \DB::table('buyings')->where('user_id', $id)->get(['product_id'])->toArray();
        $buyingIds = array_column(json_decode(json_encode($buyingIds), true), 'product_id');

        return \DB::table('products')->whereIn('id', $buyingIds)->get();
    }

    public function numberUnreadNotification($id)
    {
        $currentUser = $this->model->find($id);
        return $currentUser
                    ->notifications()
                    ->where('status', 0)
                    ->count();
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function decreaseFiningCancelCount($userId)
    {
        $user = $this->model->find($userId);
        if ($user->cancel_fining_count <= 1) {
            $user->cancel_fining_count = 0;
            $user->save();
        } else {
            $user->decrement('cancel_fining_count');
        }
    }

    public function reviewedEmotional($userId)
    {
        $user = $this->model->find($userId);
        $numberGoodReviewed = $user->reviews()
                                ->where('rating', '>=', 4)
                                ->count();
        $numberNormalReviewed = $user->reviews()
                                ->where('rating', '>=', 2)
                                ->where('rating', '<', 4)
                                ->count();
        $numberBadReviewed = $user->reviews()
                                ->where('rating', '>=', 1)
                                ->where('rating', '<', 2)
                                ->count();
        return [
            'good' => $numberGoodReviewed,
            'normal' => $numberNormalReviewed,
            'bad' => $numberBadReviewed,
        ];
    }
    
    public function publicProducts($userId, $perPage)
    {
        $user = $this->model->find($userId);
        return $user->products()
                        ->with(['images'])
                        ->where(function ($query) {
                            $query
                            ->where('products.status', 1)
                            ->orWhere('products.status', 4);
                        })
                        ->orderBy('products.created_at', 'DESC')
                        ->paginate($perPage);
    }
}
