<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $response = $next($request);
        $ip = $request->ip();

        Log::channel('input')->debug('Incoming Request', [
            'ip' => $ip,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'body' => $request->except(['password', 'password_confirmation']),
        ]);

        if (config('app.env') !== 'production') {
            Log::channel('output')->debug('Outgoing Response', [
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all(),
                'body' => $response->getContent(),
            ]);
        }

        return $response;
    }
}
