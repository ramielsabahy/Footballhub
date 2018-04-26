<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tymon\JWTAuth\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class RefreshToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        try {
            $newToken = $this->auth->setRequest($request)->parseToken()->refresh();
        } catch (TokenExpiredException $e) {
            $resp = new \App\Http\Helpers\ServiceResponse();
            $resp->Message = 'token_expired';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            // return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
            return $this->respond('tymon.jwt.expired', $resp, $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            $resp = new \App\Http\Helpers\ServiceResponse();
            $resp->Message = 'token_invalid';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            // return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
            return $this->respond('tymon.jwt.invalid', $resp, $e->getStatusCode(), [$e]);
        }

        // send the refreshed token back to the client
        $response->headers->set('Authorization', 'Bearer '.$newToken);

        return $response;
    }
}
