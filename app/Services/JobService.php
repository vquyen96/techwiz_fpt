<?php
namespace App\Services;

use App\Repositories\JobRepository;

class JobService implements JobServiceInterface
{
    private $jobRepository;

    public function __construct(
        JobRepository $jobRepository
    ) {
        $this->jobRepository = $jobRepository;
    }

    public function store($data)
    {
        $this->jobRepository->create($data);
    }
}
