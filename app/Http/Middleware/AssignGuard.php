<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AssignGuard
{   use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$guard =null)
    {
        if($guard != null)
            auth()->shouldUse($guard);//should your user guard /table
            $token = $request->header('auth-token');
            $request->headers->set('auth-token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            try {
              //  $user = $this->auth->authenticate($request);  //check authenticated user
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                return  $this -> returnError('401','Unauthenticated user');
            } catch (JWTException $e) {

                return  $this -> returnError('', 'token_invalid'.$e->getMessage());
            }

            return $next($request);



    }

}
