<?php

namespace App\Services;

use App\Entities\UserEntity;
use App\Repositories\Contracts\IUserRepository;
use Throwable;

class UserService
{
    public function __construct(
        private readonly IUserRepository $userRepository,
    )
    {
    }

    public function create(UserEntity $userEntity): UserEntity
    {
        try {
            return $this->userRepository->create($userEntity);
        }catch (Throwable $exception){
            throw $exception;
        }
    }

    public function validateXApiToken(string $token): bool
    {
        $userEntity = $this->userRepository->getUserInfoByToken($token);

        if ($userEntity->getXApiKey() == $token)
            return true;

        return false;
    }
}
