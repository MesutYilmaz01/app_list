<?php
 
namespace App\Modules\User\Infrastructure\Middlewares;

use App\Modules\User\Domain\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->user_type != UserType::ADMIN->value) {
            return response()->json(['message' => 'Only admins can do this operation.'], 400);
        }
 
        return $next($request);
    }
}