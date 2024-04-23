<?php

namespace App\Repositories\Contracts;

use App\Entities\BaseEntity;
use App\Entities\Collections\AnnouncementCollection;
use App\Entities\VehicleEntity;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

interface IVehicleRepository
{
    public function create(VehicleEntity $vehicleData): ?VehicleEntity;
}
