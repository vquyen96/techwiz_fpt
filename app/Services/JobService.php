<?php
namespace App\Services;

use App\Enums\JobCv\Status;
use App\Enums\JobCv\Type;
use App\Enums\User\Role;
use App\Models\Save;
use App\Repositories\JobCvRepository;
use App\Repositories\JobLocationRepository;
use App\Repositories\JobRepository;
use App\Repositories\SaveRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobService implements JobServiceInterface
{
    private $jobRepository;
    private $jobLocationRepository;
    private $jobCvRepository;
    private $saveRepository;

    public function __construct(
        JobRepository $jobRepository,
        JobLocationRepository $jobLocationRepository,
        JobCvRepository $jobCvRepository,
        SaveRepository $saveRepository
    ) {
        $this->jobRepository = $jobRepository;
        $this->jobLocationRepository = $jobLocationRepository;
        $this->jobCvRepository = $jobCvRepository;
        $this->saveRepository = $saveRepository;
    }

    public function search($data)
    {
        $jobs = $this->jobRepository->getActive();
        $search = $data['search'];
        if ($search != null) {
            $jobs = $jobs->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('keyword', 'like', '%'.$search.'%')
                    ->orWhere('requirement', 'like', '%'.$search.'%');
            });
        }
        if ($data['hot'] != 0) {
            $jobs = $jobs->where('hot', $data['hot']);
        }
        if ($data['location'] != 0) {
            $jobIds = $this->jobLocationRepository
                ->findWhere('location_id', $data['location'])
                ->get(['job_id'])->toArray();
            $jobIds = array_column(json_decode(json_encode($jobIds), true), 'job_id');
            $jobs = $jobs->whereIn('id', $jobIds);
        }
        if ($data['category'] != 0) {
            $jobs = $jobs->where('category_id', $data['category']);
        }
        if ($data['experience'] != 0) {
            $jobs = $jobs->where('year_experience', '>=', $data['experience']);
        }
        if ($data['expired'] != 0) {
            //
        }
        switch ($data['order']) {
            case 0:
                $jobs = $jobs->orderByDesc('start_date');
                break;
            case 1:
                $jobs = $jobs->orderBy('start_date', 'asc');
                break;
            case 2:
                $jobs = $jobs->orderByDesc('view');
                break;
            case 3:
                $jobs = $jobs->orderBy('view', 'asc');
                break;
            default:
                return $jobs->get();
                break;
        }
        $jobs =  $jobs->paginate($data['count'])->toArray();
        return [
            'jobs' =>  $jobs['data'],
            'total' => $jobs['total']
        ];
    }

    public function store($data, $locations)
    {
        $company = Auth::user()->company;
        if (!$company) {
            abort(403, 'Your request was rejected');
        }

        $jobId = uniqid();
        $data['id'] = $jobId;
        $data['company_id'] = $company->id;
        $data['status'] = 1;
        $data['type'] = 0;
        $data['expired'] = 7;
        $data['view'] = 0;
        $data['start_date'] = Carbon::createFromFormat(
            'm/d/Y H:i',
            $data['start_date']
        );
        $data['expired_date'] = Carbon::createFromFormat(
            'm/d/Y H:i',
            $data['expired_date']
        );
        $locationIds = explode(',', $locations);
        $jobLocations = [];
        DB::transaction(function () use ($jobLocations, $locationIds, $data, $jobId) {
            $job = $this->jobRepository->create($data);
            foreach ($locationIds as $locationId) {
                $jobLocations[] = [
                    'location_id' => $locationId,
                    'job_id' => $jobId
                ];
            }
            $this->jobLocationRepository->insertMany($jobLocations);
        });

        return true;
    }

    public function show($id)
    {
        return $this->jobRepository->find($id);
//        $user = $this->userRepository->find(Auth::id());
//        dd(Auth::id());
//        $cvs = $user->cvs;
//        dd($cvs);
//        $cvs = array_column(json_decode(json_encode($cvs), true), 'id');
//
//        $job = $this->jobRepository
//            ->with(array('jobCvs' => function ($query) use ($cvs) {
//                $query->whereIn('user_id', $cvs);
//            }))->find($id);
//        dd($job);
    }

    public function apply($id)
    {
        $user = Auth::user();
        if ($user->role != Role::USER) {
            abort(403, 'Your request was rejected');
        }
        $cv = $user->cvs->last();
        if ($cv == null) {
            abort(400, 'You don\'t has any CV');
        }
        return $this->jobCvRepository->create([
            'job_id' => $id,
            'cv_id' => $cv->id,
            'type' => Status::ACTIVE
        ]);
    }

    public function save($id)
    {
        $user = Auth::user();
        $save = $this->saveRepository
            ->findWhere([
                'job_id' => $id,
                'user_id' => $user->id
            ])->last();
        if ($save != null) {
            abort(400, 'You saved before');
        }
        return $this->saveRepository->create([
            'job_id' => $id,
            'user_id' => $user->id,
            'status' => Status::ACTIVE
        ]);
    }
}
