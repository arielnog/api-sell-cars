<?php

namespace Database\Seeders;

use App\DataTransferObjects\CreateUserDTO;
use App\Factories\Entities\UserFactory;
use App\Services\UserService;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userEntity = UserFactory::fromArray([
            'uuid' => Uuid::uuid4()->toString(),
            'application_name' => "Front Application Developer",
            'email' => "suporte@application.com.br",
            'password' => "123456",
            'x_api_key' => "01HVYX4Q6SV0D67DM1XX9AHC0X",
        ]);

        $service = app(UserService::class);
        $service->create($userEntity);
    }
}
