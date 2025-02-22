<?php
 
namespace App\Modules\User\Infrastructure\Middlewares;

use App\Modules\User\Application\Manager\UserMiddlewareManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class AdminMiddleware
{
    private UserMiddlewareManager $userMiddlewareManager;

    public function __construct(UserMiddlewareManager $userMiddlewareManager)
    {
        $this->userMiddlewareManager = $userMiddlewareManager;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->userMiddlewareManager->isAdmin()) {
            return response()->json(['message' => 'Only admins can do this operation.'], 400);
        }
 
        return $next($request);
    }
}