<?php

namespace Database\Seeders;

use App\Factories\Entities\AnnouncementFactory;
use App\Factories\Entities\VehicleFactory;
use App\Services\AnnouncementService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = self::getMock();
        $announcementService = app(AnnouncementService::class);

        foreach ($data as $item) {
            $announcementEntity = AnnouncementFactory::fromArray($item['announcement']);
            $vehicleEntity = VehicleFactory::fromArray($item['vehicle']);

            $announcementService->createWithVehicle($announcementEntity, $vehicleEntity);
        }

    }

    private static function getMock(): array
    {
        return [
            [
                "announcement" => [
                    "uuid" => Uuid::uuid4()->toString(),
                    "title" => "Céu ta Preto",
                    "description" => "Celtinha naquele modelo, no precinho, conservado",
                    "city" => "Salvador",
                    "price" => 14000.50,
                    "status" => "active",
                    "phone_number" => "(71) 99784-5123"
                ],
                "vehicle" => [
                    "uuid" => Uuid::uuid4()->toString(),
                    "year" => 2011,
                    "brand" => "Chevrolet",
                    "model" => "Celta",
                    "license_plate" => "JJJ4444",
                    "status" => "new",
                    "transmission" => "manual",
                    "mileage" => 147147,
                ]
            ]
        ];
    }
}
