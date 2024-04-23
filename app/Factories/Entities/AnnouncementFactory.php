<?php

namespace App\Factories\Entities;

use App\Entities\AnnouncementEntity;
use App\Models\Announcement;
use App\Traits\Iterator;
use App\ValueObjects\StatusAnnouncement;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AnnouncementFactory
{
    use Iterator;

    public static function fromArray(array $data): AnnouncementEntity
    {
        $createdAt = self::getData($data, 'created_at');
        $updatedAt = self::getData($data, 'updated_at');
        $status = self::getData($data, 'status');
        $vehicle = self::getData($data, 'vehicle');
        $uuid = self::getData($data, 'uuid');

        $announcement = new AnnouncementEntity(
            uuid: !is_null($uuid) ? $uuid : Uuid::uuid4()->toString(),
            title: self::getData($data, 'title'),
            description: self::getData($data, 'description'),
            status: StatusAnnouncement::fromString($status),
            city: self::getData($data, 'city'),
            price: self::getData($data, 'price'),
            phoneNumber: self::getData($data, 'phone_number'),
            id: self::getData($data, 'id'),
            createdAt: !is_null($createdAt) ? new Carbon($createdAt) : null,
            updatedAt: !is_null($updatedAt) ? new Carbon($updatedAt) : null,
        );

        if (!empty($vehicle)) {
            $vehicleEntity = VehicleFactory::fromArray($vehicle);
            $announcement->setVehicle($vehicleEntity);
        }

        return $announcement;
    }

    public static function fromModel(Announcement $model): AnnouncementEntity
    {
        return self::fromArray($model->toArray());
    }
}
