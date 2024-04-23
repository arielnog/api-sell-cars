<?php

namespace App\DataTransferObjects;


use App\Traits\Iterator;

class BuildSimulationDTO
{
    public function __construct(
        private readonly string $uuidAnnouncement,
        private readonly float $inputValue,
        private readonly array $installments = [6,12.48],
    )
    {
    }

    public function getInputValue(): float
    {
        return $this->inputValue;
    }

    public function getUuidAnnouncement(): string
    {
        return $this->uuidAnnouncement;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }
}
