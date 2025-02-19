<?php

namespace App\Providers;

use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Category\Domain\IRepository\IBaseEloquentRepository;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Category\Infrastructure\Repository\BaseEloquentRepository;
use App\Modules\Category\Infrastructure\Repository\CategoryRepository;
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
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(CategoryManager::class, CategoryManager::class);
    }
}
