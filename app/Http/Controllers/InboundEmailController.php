<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InboundEmailController extends Controller
{
    public function parseEmail(Request $request)
    {
        Log::info($request);
        // https://laravel-news.com/laravel-inbound-email
        // TODO : 1) Securing the Webhook and 2) make GET api Call with basic auth via mailgun secret key, to GET attachment .csv body
        return response()->json(['status'=>'ok'], 200);
    }
}
