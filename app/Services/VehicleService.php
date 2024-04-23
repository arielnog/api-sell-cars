<?php

namespace App\Services;

use App\Entities\VehicleEntity;
use App\Repositories\Contracts\IVehicleRepository;

class VehicleService
{
    public function __construct(
        private readonly IVehicleRepository $vehicleRepository
    )
    {
    }

    public function create(VehicleEntity $vehicleEntity): ?VehicleEntity
    {
        try {
            return $this->vehicleRepository->create($vehicleEntity);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
