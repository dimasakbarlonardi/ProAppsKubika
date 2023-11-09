<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "https://dev.pro-apps.xyz/payments/midtrans-notifications",
        "/payments/midtrans-notifications",
        "/api/v1/store/insert-electric/*/*",
        "/api/v1/store/insert-water/*/*",

    ];
}
