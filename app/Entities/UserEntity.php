<?php

namespace App\Entities;

use App\ValueObjects\Email;
use Carbon\Carbon;

class UserEntity extends BaseEntity
{
    public function __construct(
        string                   $uuid,
        private string  $applicationName,
        private Email   $email,
        private ?string $password = null,
        private ?string $xApiKey = null,
        ?int                     $id = null,
        ?Carbon                  $createdAt = null,
        ?Carbon                  $updatedAt = null,
    )
    {
        parent::__construct(
            uuid: $uuid,
            id: $id,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    public function getXApiKey(): ?string
    {
        return $this->xApiKey;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getUuid(),
            'applicationName' => $this->applicationName,
            'email' => $this->email->toString(),
            'xApiKey' => $this->xApiKey,
            'createdAt' => $this->getCreatedAt()->toDateTimeString(),
            'updatedAt' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }

    public function toCreate(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'application_name' => $this->applicationName,
            'email' => $this->email->toString(),
            'x_api_key' => $this->xApiKey,
            'password' => $this->password,
        ];
    }
}
