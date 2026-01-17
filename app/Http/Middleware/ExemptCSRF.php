<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class ExemptCSRF extends Middleware
{
    protected $except = [
        'cregister-face-registration',
    ];

    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
