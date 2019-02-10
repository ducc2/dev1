<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //'singup', 'singup/*', 'login', 'login/*', 'rpc/walletnotify','v1/api/rpc/*', 'shop', 'shop/*', 'pet', 'pet/*'
        'singup', 'singup/*', 'login', 'login/*', 'rpc/walletnotify','v1/api/rpc/*', 'v1/pet/api/*' ,'pet/userChk','/mail/api','v1/api/*'
    ];
}
