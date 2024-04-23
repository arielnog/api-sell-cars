<?php

namespace App\Factories\Entities;

use App\Entities\UserEntity;
use App\Models\User;
use App\Traits\Iterator;
use App\ValueObjects\Email;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UserFactory
{
    use Iterator;

    public static function fromArray(array $data): UserEntity
    {
        $email = self::getData($data, 'email');
        $createdAt = self::getData($data, 'created_at');
        $updatedAt = self::getData($data, 'updated_at');
        $uuid = self::getData($data, 'uuid');

        return new UserEntity(
            uuid: !is_null($uuid) ? $uuid : Uuid::uuid4()->toString(),
            applicationName: self::getData($data, 'application_name','applicationName'),
            email: new Email($email),
            xApiKey: self::getData($data, 'x_api_key', 'xApiKey'),
            id: self::getData($data, 'id'),
            createdAt: !is_null($createdAt) ? new Carbon($createdAt) : null,
            updatedAt: !is_null($updatedAt) ? new Carbon($updatedAt) : null,
        );
    }

    public static function fromModel(User $model): UserEntity
    {
        return self::fromArray($model->toArray());
    }
}
