<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class validateApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authkey = env("VALID_AUTH_KEY", "0ntoi95uq264gqr5ofpud9ip3kyxa15dgy1oitp0q5mfbpael1");
        $header = $request->header('Authorization');
        if ($header !== $authkey) {
            if ($request->wantsJson()) {
                return response()->json(['Message', 'You do not access to this module.'], 403);
            }
            abort(403, 'You do not access to this module.');
        }
        return $next($request);
    }
}
