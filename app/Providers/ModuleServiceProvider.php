<?php

namespace App\Providers;

use App\Modules\ArtificialIntelligence\Application\Manager\ArtificialIntelligenceManager;
use App\Modules\ArtificialIntelligence\Domain\Interfaces\IArtificialIntelligence;
use App\Modules\ArtificialIntelligence\Infrastructure\ThirdParty\Gemini;
use App\Modules\Authority\Application\Manager\AuthorityManager;
use App\Modules\Authority\Application\Manager\UserAuthorityManager;
use App\Modules\Authority\Domain\Aggregate\UserAuthorityAggregate;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\IRepository\IAuthorityRepository;
use App\Modules\Authority\Domain\IRepository\IUserAuthorityRepository;
use App\Modules\Authority\Domain\Policies\UserAuthorityPolicy;
use App\Modules\Authority\Infrastructure\Repository\AuthorityRepository;
use App\Modules\Authority\Infrastructure\Repository\UserAuthorityRepository;
use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Category\Infrastructure\Repository\CategoryRepository;
use App\Modules\Comment\Domain\Aggregate\CommentAggregate;
use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\IRepository\ICommentRepository;
use App\Modules\Comment\Domain\Policies\CommentPolicy;
use App\Modules\Comment\Infrastructure\Repository\CommentRepository;
use App\Modules\Dislike\Application\Manager\DislikeCommentManager;
use App\Modules\Dislike\Application\Manager\DislikeUserListManager;
use App\Modules\Dislike\Domain\IRepository\IDislikeCommentRepository;
use App\Modules\Dislike\Domain\IRepository\IDislikeUserListRepository;
use App\Modules\Dislike\Infrastructure\Repository\DislikeCommentRepository;
use App\Modules\Dislike\Infrastructure\Repository\DislikeUserListRepository;
use App\Modules\Like\Application\Manager\LikeCommentManager;
use App\Modules\Like\Application\Manager\LikeUserListManager;
use App\Modules\Like\Domain\IRepository\ILikeCommentRepository;
use App\Modules\Like\Domain\IRepository\ILikeUserListRepository;
use App\Modules\Like\Infrastructure\Repository\LikeCommentRepository;
use App\Modules\Like\Infrastructure\Repository\LikeUserListRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\Shared\Repository\IBaseEloquentRepository;
use App\Modules\User\Application\Manager\AuthManager;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\User\Domain\IRepository\IUserRepository;
use App\Modules\User\Infrastructure\Repository\UserRepository;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserList\Domain\IRepository\IUserListRepository;
use App\Modules\UserList\Domain\Policies\UserListPolicy;
use App\Modules\UserList\Infrastructure\Repository\UserListRepository;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\Aggregate\UserListItemAggregate;
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
        Gate::policy(CommentEntity::class, CommentPolicy::class);
        Gate::policy(UserAuthorityEntity::class, UserAuthorityPolicy::class);


        //Bindings
        $this->app->singleton(UserListAggregate::class);
        $this->app->singleton(UserListItemAggregate::class);
        $this->app->singleton(CommentAggregate::class);
        $this->app->singleton(UserAuthorityAggregate::class);
        $this->app->bind(LoggerInterface::class, function () {
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
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
        $this->app->bind(LikeCommentManager::class, LikeCommentManager::class);
        $this->app->bind(LikeUserListManager::class, LikeUserListManager::class);
        $this->app->bind(ILikeCommentRepository::class, LikeCommentRepository::class);
        $this->app->bind(ILikeUserListRepository::class, LikeUserListRepository::class);
        $this->app->bind(DislikeCommentManager::class, DislikeCommentManager::class);
        $this->app->bind(DislikeUserListManager::class, DislikeUserListManager::class);
        $this->app->bind(IDislikeCommentRepository::class, DislikeCommentRepository::class);
        $this->app->bind(IDislikeUserListRepository::class, DislikeUserListRepository::class);
        $this->app->bind(IArtificialIntelligence::class, Gemini::class);
        $this->app->bind(ArtificialIntelligenceManager::class, ArtificialIntelligenceManager::class);
        $this->app->bind(AuthorityManager::class, AuthorityManager::class);
        $this->app->bind(IAuthorityRepository::class, AuthorityRepository::class);
        $this->app->bind(UserAuthorityManager::class, UserAuthorityManager::class);
        $this->app->bind(IUserAuthorityRepository::class, UserAuthorityRepository::class);

    }
}
