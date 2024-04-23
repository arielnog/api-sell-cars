<?php

namespace App\Repositories;

use App\Entities\AnnouncementEntity;
use App\Entities\Collections\AnnouncementCollection;
use App\Enums\StatusAnnouncementEnum;
use App\Factories\Entities\AnnouncementFactory;
use App\Models\Announcement;
use App\Repositories\Contracts\IAnnouncementRepository;
use Illuminate\Support\Arr;

class AnnouncementRepository implements IAnnouncementRepository
{

    public function __construct(
        private readonly Announcement $model
    )
    {
    }

    public function create(AnnouncementEntity $announcementEntity): ?AnnouncementEntity
    {
        $announcement = $this->model->create(
            Arr::only($announcementEntity->toArray(),
                [
                    'uuid',
                    'title',
                    'image_path',
                    'description',
                    'status',
                    'city',
                    'phone_number',
                    'price'
                ]
            )
        );

        if (is_null($announcement))
            return null;

        return AnnouncementFactory::fromModel($announcement);
    }

    public function getAnnouncementWithVehicleByUuid(string $uuid): AnnouncementEntity
    {
        $announcement = $this->model->with('vehicle')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return AnnouncementFactory::fromModel($announcement);
    }

    public function getListByParam(?string $param = null): AnnouncementCollection
    {

        $query = $this->model->with(['vehicle' => function ($query) {
            $query->orderBy('brand', 'asc')
                ->orderBy('year', 'desc');
        }]);

        if (!is_null($param)) {
            $query->whereHas('vehicle', function ($query) use ($param) {
                $query->where('brand','like', "%{$param}%")
                    ->orWhere('model','like', "%{$param}%");
            });
        }

        $collection = $query
            ->where('status', StatusAnnouncementEnum::ACTIVE->value)
            ->get();

        return AnnouncementCollection::fromCollection($collection);
    }
}
