<?php

namespace App\Repositories\Contracts;

use App\Entities\UserEntity;

interface IUserRepository
{
    public function create(UserEntity $userUserEntity): UserEntity;
   public function getUserInfoByToken(string $token): UserEntity;
}
