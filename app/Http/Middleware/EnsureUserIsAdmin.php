<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Admin paneline yalnızca role='admin' olan kullanıcıların girmesine izin ver.
     * Bu middleware 'auth' ile birlikte kullanılmalıdır; giriş yapılmamışsa
     * zaten 'auth' middleware'i devreye girer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
