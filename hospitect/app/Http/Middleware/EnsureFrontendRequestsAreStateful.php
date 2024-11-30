<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Config;

class EnsureFrontendRequestsAreStateful
{
    public function handle($request, $next)
    {
        Config::set('session.domain', $request->getHost());

        return $next($request);
    }
}
