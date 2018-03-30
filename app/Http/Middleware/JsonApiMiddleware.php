<?php

namespace App\Http\Middleware;

use Closure;

class JsonApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $needle = 'application/vnd.api+json';

        if($request->hasHeader('Content-Type')) {

            $contentType = $request->header('Content-Type');

            $count = 0;

            if(starts_with($contentType, $needle)) {
                $leftover = str_replace($needle, '', $contentType, $count);
            }
            else {
                return $this->errorResponse(415);
            }

            if(! empty($leftover) || $count > 1) {
                return $this->errorResponse(415);
            }
        }
        else {
            return $this->errorResponse(415);
        }

        return $next($request);
    }

    protected function errorResponse(int $status, string $contentType = 'application/vnd.api+json')
    {
        return response()->json(null, $status, ['Content-Type' => $contentType]);
    }
}