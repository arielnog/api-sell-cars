<?php

namespace Tests\Unit\Services;

use App\DataTransferObjects\BuildSimulationDTO;
use App\Entities\Collections\AnnouncementCollection;
use App\Exceptions\InvalidArgumentException;
use App\Factories\Entities\AnnouncementFactory;
use App\Factories\Entities\VehicleFactory;
use App\Repositories\AnnouncementRepository;
use App\Repositories\Contracts\IAnnouncementRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Services\AnnouncementService;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AnnouncementServiceTest extends TestCase
{
    protected IAnnouncementRepository $announcementRepository;
    protected VehicleService $vehicleService;
    protected IVehicleRepository $vehicleRepository;
    protected AnnouncementService $classUnderTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vehicleService = Mockery::mock(VehicleService::class);
        $this->vehicleRepository = Mockery::mock(IVehicleRepository::class);
        $this->announcementRepository = Mockery::mock(AnnouncementRepository::class);
        $this->classUnderTest = new AnnouncementService(
            announcementRepository: $this->announcementRepository,
            vehicleService: $this->vehicleService
        );
    }

    public function testCreateAnnouncementAndVehicleWithSuccess()
    {
        $mock = self::getMock();
        $announcementEntity = AnnouncementFactory::fromArray($mock['announcement']);
        $vehicleEntity = VehicleFactory::fromArray($mock['announcement']['vehicle']);

        $this->announcementRepository
            ->shouldReceive('create')
            ->andReturn($announcementEntity);

        $this->vehicleService
            ->shouldReceive('create')
            ->andReturn();

        $this->vehicleRepository
            ->shouldReceive('create')
            ->andReturn($vehicleEntity);

        $result = $this->classUnderTest->createWithVehicle($announcementEntity, $vehicleEntity);
        self::assertEquals($mock['announcement']['uuid'], $result);
    }

    public function testCreateAnnouncementAndVehicleWithErrorOnFirstStep()
    {
        self::expectException(InvalidArgumentException::class);

        $mock = self::getMock();
        $announcementEntity = AnnouncementFactory::fromArray($mock['announcement']);
        $vehicleEntity = VehicleFactory::fromArray($mock['announcement']['vehicle']);

        $this->announcementRepository
            ->shouldReceive('create')
            ->andReturnNull();

        $this->classUnderTest->createWithVehicle($announcementEntity, $vehicleEntity);
    }

    public function testGetSimulationFromAnnouncementHasSuccess()
    {
        $mockData = self::getMock();

        $announcementEntity = AnnouncementFactory::fromArray($mockData['announcement']);
        $announcementEntity->setVehicle(
            VehicleFactory::fromArray($mockData['announcement']['vehicle'])
        );
        $announcementUuid = $announcementEntity->getUuid();

        $buildSimulationDto = new BuildSimulationDTO(
            $announcementUuid,
            1300.00,
            [6, 12]
        );

        $this->announcementRepository
            ->shouldReceive('getAnnouncementWithVehicleByUuid')
            ->andReturn($announcementEntity);

        $result = $this->classUnderTest->doSimulation($buildSimulationDto);
        $simulation = $result->getSimulation();

        self::assertCount(2, $simulation);
        self::assertEquals(2407.73, $simulation[0]['total']);
        self::assertEquals(1239.91, $simulation[1]['total']);
    }

    public function testGetListWithSuccess()
    {
        $mockData = self::getMock();
        $announcementCollection = AnnouncementCollection::fromArray($mockData);

        $this->announcementRepository
            ->shouldReceive('getListByParam')
            ->andReturn($announcementCollection);

        $result = $this->classUnderTest->getList();

        self::assertInstanceOf(AnnouncementCollection::class,$result);
    }

    public static function getMock(): array
    {
        return [
            "announcement" => [
                "uuid" => Uuid::uuid4()->toString(),
                "title" => "Céu ta Preto",
                "image_path" => "https://carros-limeira.temusados.com.br/img/Veiculos/1664142/chevrolet-celta-preto-2012-20220407161620618.jpg",
                "description" => "Celtinha naquele modelo, no precinho, conservado",
                "city" => "Salvador",
                "price" => 14000.50,
                "status" => "active",
                "phone_number" => "(71) 99784-5123",
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
            ],
        ];
    }

}
