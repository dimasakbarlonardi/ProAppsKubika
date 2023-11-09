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
<<<<<<< HEAD
        "https://demo.pro-apps.xyz/payments/midtrans-notifications",
        "/payments/midtrans-notifications"
=======
        "https://dev.pro-apps.xyz/payments/midtrans-notifications",
        "/payments/midtrans-notifications",
        "/api/v1/store/insert-electric/*/*",
        "/api/v1/store/insert-water/*/*",

>>>>>>> 1bf153fefb7f82492a86d5d5ca0a41c39d251ee9
    ];
}
