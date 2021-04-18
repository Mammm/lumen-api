<?php


namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() == "OPTIONS") {
            return response()->json('ok', 200, [
                # 下面参数视request中header而定
                'Access-Control-Allow-Origin' => "*",
                'Access-Control-Allow-Headers' => 'token, Content-Type, Authorization, X-Requested-With',
                'Access-Control-Allow-Methods' => '*']);
        }

        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
