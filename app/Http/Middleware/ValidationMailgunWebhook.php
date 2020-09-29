<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class ValidationMailgunWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->isMethod('post')) {
            abort(Response::HTTP_FORBIDDEN, 'Only POST requests are allowed.');
        }

        if ($this->verify($request)) {
            return $next($request);
        }

        Log::error('Middleware check: NOT passed, abort(403)!');
        abort(Response::HTTP_FORBIDDEN);
    }

    protected function verify($request) {
        $req_timestamp = $request->input('timestamp');
        if (abs(time() - $req_timestamp) > 15) {
            return false;
        }

        $token = $request->input('token');
        $signingKey = config('services.mailgun.webhook_signing_key') ?? abort('Mailgun Webhook Signing Key not available in .env');
        $signature  = $request->input('signature');

        return hash_equals(hash_hmac('sha256', $req_timestamp.$token, $signingKey), $signature);
    }
}
