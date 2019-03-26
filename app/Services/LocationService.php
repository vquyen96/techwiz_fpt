<?php
namespace App\Services;

use App\Repositories\LocationRepository;

class LocationService implements LocationServiceInterface
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getAll()
    {
        return $this->locationRepository->getAll();
    }
}