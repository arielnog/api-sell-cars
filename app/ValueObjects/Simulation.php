<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;

final class Simulation
{
    public function __construct(
        private readonly float $inputValue,
        private readonly float $price
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->price <= $this->inputValue) {
            throw new InvalidArgumentException(
                400,
                'Calculator input value must be greater than price'
            );
        }
    }

    public function calculateByInstallments(int $installmentNumber): float
    {
        $taxPercent = $this->selectTaxPercent($installmentNumber);
        $newPrice = (($taxPercent / 100) * $this->price) + $this->price;
        $installmentValue = ($newPrice - $this->inputValue) / $installmentNumber;

        return (float)number_format($installmentValue, 2, '.', '');
    }

    private function selectTaxPercent(int $installmentNumber): float
    {
        return match ($installmentNumber) {
            6 => 12.47,
            12 => 15.56,
            48 => 18.69,
            default => 20.50,
        };
    }
}
