<?php

namespace App\Repositories;

use App\Entities\UserEntity;
use App\Factories\Entities\UserFactory;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

class UserRepository implements IUserRepository
{
    public function __construct(
        private readonly User $model
    )
    {
    }

    public function create(UserEntity $userEntity): UserEntity
    {
        $userModel = $this->model->create(
            $userEntity->toCreate()
        );

        return UserFactory::fromModel($userModel);
    }

    public function getUserInfoByToken(string $token): UserEntity
    {
        $user = User::where('x_api_key', $token)->firstOrFail();

        return UserFactory::fromModel($user);
    }
}
