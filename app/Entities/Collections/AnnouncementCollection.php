<?php

namespace App\Entities\Collections;

use App\Entities\AnnouncementEntity;
use App\Factories\Entities\AnnouncementFactory;
use Illuminate\Support\Collection;

class AnnouncementCollection extends Collection
{
    protected $items = [];

    public function __construct(AnnouncementEntity ...$announcements)
    {
        parent::__construct($announcements);
    }

    public function addAnnouncement(AnnouncementEntity $entity): self
    {
        $this->items[] = $entity;
        return $this;
    }

    public static function fromArray(array $data): self
    {
        $announcementEntities = [];

        foreach ($data as $quotation) {
            $announcementEntities[] = AnnouncementFactory::fromArray($quotation);
        }

        return new self(...$announcementEntities);
    }

    public static function fromCollection(Collection $data): self
    {
        $announcementEntities = [];

        foreach ($data as $quotation) {

            $announcementEntities[] = AnnouncementFactory::fromModel($quotation);
        }

        return new self(...$announcementEntities);
    }

    /**
     * @return array
     */
    public function toSelectListResponse(): array
    {
        if (empty($this->items)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'announcement_id' => $item->getUuid(),
                'announcement_price' => $item->getPrice(),
                'vehicle_brand' => $item->getVehicle()->getBrand(),
                'vehicle_model' => $item->getVehicle()->getModel(),
                'vehicle_year' => $item->getVehicle()->getYear(),

            ];
        },
            $this->items
        );
    }
}
