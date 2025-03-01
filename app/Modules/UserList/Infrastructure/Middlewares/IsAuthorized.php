<?php

namespace App\Modules\UserList\Infrastructure\Middlewares;

use App\Modules\UserList\Application\Manager\UserListManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAuthorized
{
    public function __construct(
        private UserListManager $userListManager
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userListAggregate = $this->userListManager->show($request->route('list_id'));
        if (!$userListAggregate->getUserListEntity()->isOwner()) {
            return response()->json(['message' => 'Anauthorized.'], 400);
        }

        return $next($request);
    }
}
