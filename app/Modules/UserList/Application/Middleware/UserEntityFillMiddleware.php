<?php

namespace App\Modules\UserList\Application\Middleware;

use App\Models\User;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Closure;
class UserEntityFillMiddleware
{
    public function __construct(private readonly UserListAggregate $userListAggregate)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->userListAggregate->setUserEntity(
            function () {
                return auth()->user();
            }
        );
        return $next($request);
    }

}
