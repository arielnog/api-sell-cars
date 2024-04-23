<?php

namespace App\Repositories;

use App\Entities\Collections\AnnouncementCollection;
use App\Entities\VehicleEntity;
use App\Factories\Entities\VehicleFactory;
use App\Models\Announcement;
use App\Models\Vehicle;
use App\Repositories\Contracts\IAnnouncementRepository;
use App\Repositories\Contracts\IVehicleRepository;
use Illuminate\Support\Arr;

class VehicleRepository implements IVehicleRepository
{
    public function __construct(
        private readonly Vehicle $model
    )
    {
    }

    public function create(VehicleEntity $vehicleData): ?VehicleEntity
    {
        $vehicle = $this->model->create(
            Arr::except($vehicleData->toArray(),
                [
                    'id',
                    'created_at',
                    'updated_at',
                ]
            )
        );

        if (is_null($vehicle))
            return null;

        return VehicleFactory::fromModel($vehicle);
    }
}
