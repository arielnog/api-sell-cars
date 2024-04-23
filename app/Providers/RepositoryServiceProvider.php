<?php

namespace App\Providers;

use App\Repositories\AnnouncementRepository;
use App\Repositories\Contracts\IAnnouncementRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IVehicleRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            IAnnouncementRepository::class,
            AnnouncementRepository::class
        );

        $this->app->bind(
            IVehicleRepository::class,
            VehicleRepository::class
        );

        $this->app->bind(
            IUserRepository::class,
            UserRepository::class
        );
    }
}
