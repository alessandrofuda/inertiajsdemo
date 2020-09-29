<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Log;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index', ['mailgunTestEmail' => env('MAILGUN_TEST_EMAIL','(define test email address in .env config)')]);
    }
}
