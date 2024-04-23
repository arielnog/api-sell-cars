<?php

namespace App\Entities;

use App\Exceptions\InvalidArgumentException;
use App\ValueObjects\Simulation;
use App\ValueObjects\StatusAnnouncement;
use Carbon\Carbon;

class AnnouncementEntity extends BaseEntity
{
    private array $simulation = [];
    private ?BaseEntity $vehicle = null;

    public function __construct(
        string                     $uuid,
        private string             $title,
        private string             $description,
        private StatusAnnouncement $status,
        private ?string            $city,
        private float              $price,
        private string             $phoneNumber,
        ?int                       $id = null,
        ?Carbon                    $createdAt = null,
        ?Carbon                    $updatedAt = null,
    )
    {
        parent::__construct(
            uuid: $uuid,
            id: $id,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->price <= 0.0)
            throw new InvalidArgumentException(
                422,
                'Price cannot be less than 0.0'
            );
    }

    public function setSimulation(float $inputValue, array $installments): void
    {
        $simulationCalculator = new Simulation($inputValue, $this->price);

        $result = [];

        foreach ($installments as $index => $installmentValue) {
            $result[$index] = [
                "installment" => $installmentValue,
                "total" => $simulationCalculator->calculateByInstallments($installmentValue)
            ];
        }

        $this->simulation = $result;
    }

    public function setVehicle(BaseEntity $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function getVehicle(): ?BaseEntity
    {
        return $this->vehicle;
    }

    public function getSimulation(): array
    {
        return $this->simulation;
    }
    
    public function getPrice(): float
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->toString(),
            'city' => $this->city,
            'price' => $this->price,
            'phone_number' => $this->phoneNumber,
            'vehicle' => $this->getVehicle()?->toArray(),
            'simulation' => $this->simulation

        ];
    }
}
