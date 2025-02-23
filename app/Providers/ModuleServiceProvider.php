<?php

namespace App\Providers;

use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Category\Infrastructure\Repository\CategoryRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\Shared\Repository\IBaseEloquentRepository;
use App\Modules\User\Application\Manager\AuthManager;
use App\Modules\User\Domain\IRepository\IUserRepository;
use App\Modules\User\Infrastructure\Repository\UserRepository;
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
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(AuthManager::class, AuthManager::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }
}
