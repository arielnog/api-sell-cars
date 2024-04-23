<?php

namespace App\Entities;

use App\Enums\StatusVehicleEnum;
use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\StatusVehicle;
use App\ValueObjects\VehicleTransmission;
use Carbon\Carbon;

class VehicleEntity extends BaseEntity
{
    public function __construct(
        string                      $uuid,
        private int                 $year,
        private string              $model,
        private string              $brand,
        private StatusVehicle       $status,
        private int                 $mileage,
        private VehicleTransmission $transmission,
        private ?string             $licensePlate = null,
        private ?int                $announcementId = null,
        ?int                        $id = null,
        ?Carbon                     $createdAt = null,
        ?Carbon                     $updatedAt = null,
    )
    {
        parent::__construct(
            $uuid,
            $id,
            $createdAt,
            $updatedAt
        );
        $this->validate();
    }

    private function validate(): void
    {
        if (!($this->year >= 1900 && $this->year <= ((int)(new \DateTime())->format('Y')))) {
            throw new InvalidArgumentException(
                422,
                "Year must be greater than 1500"
            );
        }

        if (!($this->mileage >= 0 && $this->mileage <= 9999999))
            throw new InvalidArgumentException(
                422,
                "Mileage must be greater than 1500"
            );

        if ($this->mileage != 0)
            $this->status = new StatusVehicle('used');

    }

    public function setAnnouncementId(?int $announcementId): void
    {
        $this->announcementId = $announcementId;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): int
    {
        return $this->year;
    }
    
    public function toArray(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'year' => $this->year,
            'model' => $this->model,
            'brand' => $this->brand,
            'license_plate' => $this->licensePlate,
            'status' => $this->status->toString(),
            'mileage' => $this->mileage,
            'transmission' => $this->transmission->toString(),
            'announcement_id' => $this->announcementId,
        ];
    }
}
