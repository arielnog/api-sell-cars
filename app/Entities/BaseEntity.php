<?php

namespace App\Entities;

use Carbon\Carbon;

abstract class BaseEntity
{

    public function __construct(
        private string  $uuid,
        private ?int    $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
