<?php

namespace App\Providers;

use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\Shared\Repository\IBaseEloquentRepository;
use App\Modules\User\Application\Manager\AuthManager;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(IBaseEloquentRepository::class, BaseEloquentRepository::class);
        $this->app->bind(CategoryManager::class, CategoryManager::class);
        $this->app->bind(AuthManager::class, AuthManager::class);
    }
}
