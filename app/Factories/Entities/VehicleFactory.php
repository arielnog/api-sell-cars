<?php

namespace App\Factories\Entities;

use App\Entities\AnnouncementEntity;
use App\Entities\VehicleEntity;
use App\Models\Announcement;
use App\Models\Vehicle;
use App\Traits\Iterator;
use App\ValueObjects\StatusAnnouncement;
use App\ValueObjects\StatusVehicle;
use App\ValueObjects\VehicleTransmission;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class VehicleFactory
{
    use Iterator;

    public static function fromArray(array $data): VehicleEntity
    {
        $createdAt = self::getData($data, 'created_at');
        $updatedAt = self::getData($data, 'updated_at');
        $status = self::getData($data, 'status');
        $transmission = self::getData($data, 'transmission');
        $uuid = self::getData($data, 'uuid');

        return new VehicleEntity(
            uuid: !is_null($uuid) ? $uuid : Uuid::uuid4()->toString(),
            year: self::getData($data, 'year'),
            model: self::getData($data, 'model'),
            brand: self::getData($data, 'brand'),
            status: StatusVehicle::fromString($status),
            mileage: self::getData($data, 'mileage'),
            transmission: VehicleTransmission::fromString($transmission),
            licensePlate: self::getData($data, 'license_plate'),
            id: self::getData($data, 'id'),
            createdAt: !is_null($createdAt) ? new Carbon($createdAt) : null,
            updatedAt: !is_null($updatedAt) ? new Carbon($updatedAt) : null,
        );
    }

    public static function fromModel(Vehicle $model): VehicleEntity
    {
        return self::fromArray($model->toArray());
    }
}
