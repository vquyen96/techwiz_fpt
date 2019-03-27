<?php
namespace App\Services;

use App\Repositories\CvRepository;
use Illuminate\Support\Facades\Auth;

class CvService implements CvServiceInterface
{
    private $cvRepository;

    public function __construct(
        CvRepository $cvRepository
    ) {
        $this->cvRepository = $cvRepository;
    }

    public function index($data)
    {
        $cvs =  $this->cvRepository->getActive();
        $search = $data['search'];
        if ($search != null) {
            $cvs = $cvs->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('introduce', 'like', '%'.$search.'%')
                    ->orWhere('experience', 'like', '%'.$search.'%')
                    ->orWhere('skill', 'like', '%'.$search.'%');
            });
        }

        if ($data['location_id'] != 0) {
            $cvs = $cvs->where('location_id', $data['location_id']);
        }
        if ($data['category_id'] != 0) {
            $cvs = $cvs->where('category_id', $data['category_id']);
        }
        if ($data['type'] != 0) {
            $cvs = $cvs->where('type', $data['type']);
        }
        if ($data['status'] != 0) {
            $cvs = $cvs->where('status', $data['status']);
        }

        $cvs = $cvs->where('salary', '>=', $data['min_salary'])
            ->where('salary', '<=', $data['max_salary'])
            ->paginate($data['count'])
            ->toArray();

        return [
            'data' => $cvs['data'],
            'total' => $cvs['total']
        ];
    }

    public function getByUser($user_id)
    {
        return $this->cvRepository
            ->findWhere(['user_id' => $user_id]);
    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();
        $data['id'] = uniqid();
        return $this->cvRepository->create($data);
    }

    public function detail($id)
    {
        return $this->cvRepository->find($id);
    }

    public function update($data, $id)
    {
        return $this->cvRepository->find($id)->update($data);
    }
}
