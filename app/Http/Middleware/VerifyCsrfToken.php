<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs yang dikecualikan dari CSRF verification
     */
    protected $except = [
        'api/webhook', // endpoint webhook Qontak
    ];
}
