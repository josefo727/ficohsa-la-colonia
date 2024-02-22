<?php

namespace App\Http\Middleware;

use Closure;

class CustomDomainMiddleware
{
    /**
     * @return mixed
     * @param mixed $request
     * @param Closure(): void $next
     */
    public function handle($request, Closure $next): mixed
    {
        if ($request->hasHeader('X-Forwarded-Host')) {
            $domain = $request->header('X-Forwarded-Host');
            $request->server->set('HTTP_HOST', $domain);
            $request->headers->set('HOST', $domain);
        }

        return $next($request);
    }
}
