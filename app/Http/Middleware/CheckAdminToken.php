<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('token_invalid', 'E3001');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('token_expired', 'E3001');
            } else {
                return $this->returnError('token_notFound', 'E3001');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('token_invalid', 'E3001');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('token_expired', 'E3001');
            } else {
                return $this->returnError('token_notFound', 'E3001');
            }
        }

        if (!$user)
            $this->returnError('token_notFound', 'E3001');
        return $next($request);
    }
}
