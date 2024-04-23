<?php

namespace App\Repositories\Contracts;

use App\Entities\AnnouncementEntity;
use App\Entities\Collections\AnnouncementCollection;


interface IAnnouncementRepository
{
    public function getListByParam(?string $param = null): AnnouncementCollection;

    public function create(AnnouncementEntity $announcementEntity): ?AnnouncementEntity;

    public function getAnnouncementWithVehicleByUuid(string $uuid): AnnouncementEntity;
}
