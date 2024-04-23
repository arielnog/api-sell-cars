<?php

namespace App\Services;

use App\DataTransferObjects\BuildSimulationDTO;
use App\Entities\AnnouncementEntity;
use App\Entities\Collections\AnnouncementCollection;
use App\Entities\VehicleEntity;
use App\Exceptions\InvalidArgumentException;
use App\Repositories\Contracts\IAnnouncementRepository;
use Throwable;

class AnnouncementService
{
    public function __construct(
        private readonly IAnnouncementRepository $announcementRepository,
        private readonly VehicleService          $vehicleService
    )
    {
    }

    public function getList(?string $search = null): AnnouncementCollection
    {
       return $this->announcementRepository
           ->getListByParam($search);
    }

    public function doSimulation(BuildSimulationDTO $simulationDTO): AnnouncementEntity
    {
        $announcement = $this->announcementRepository
            ->getAnnouncementWithVehicleByUuid($simulationDTO->getUuidAnnouncement());

        $announcement->setSimulation(
            $simulationDTO->getInputValue(),
            $simulationDTO->getInstallments()
        );

        return $announcement;
    }

    public function createWithVehicle(
        AnnouncementEntity $announcementEntity,
        VehicleEntity      $vehicleEntity
    ): string
    {
        try {
            $announcement = $this->announcementRepository->create($announcementEntity);

            if (is_null($announcement))
                throw new InvalidArgumentException(
                    statusCode: 422,
                    message: "Error on creating announcement",
                );

            $vehicleEntity->setAnnouncementId($announcement->getId());

            $this->vehicleService->create($vehicleEntity);

            return $announcement->getUuid();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
