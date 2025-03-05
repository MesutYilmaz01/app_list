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
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use App\Modules\UserList\Domain\Policies\UserListPolicy;;
use App\Modules\UserList\Infrastructure\Repository\UserListRepository;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;
use App\Modules\UserListItem\Domain\Policies\UserListsItemPolicy;
use App\Modules\UserListItem\Infrastructure\Repository\UserListItemRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

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
        //Policies
        Gate::policy(UserListsItemEntity::class, UserListsItemPolicy::class);
        Gate::policy(UserListEntity::class, UserListPolicy::class);


        //Bindings
        $this->app->singleton(UserListAggregate::class);
        $this->app->bind(LoggerInterface::class, function() {
            return Log::getLogger();
        });
        $this->app->bind(IBaseEloquentRepository::class, BaseEloquentRepository::class);
        $this->app->bind(CategoryManager::class, CategoryManager::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(AuthManager::class, AuthManager::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(UserListManager::class, UserListManager::class);
        $this->app->bind(IUserListRepository::class, UserListRepository::class);
        $this->app->bind(UserListItemManager::class, UserListItemManager::class);
        $this->app->bind(IUserListItemRepository::class, UserListItemRepository::class);
    }
}
