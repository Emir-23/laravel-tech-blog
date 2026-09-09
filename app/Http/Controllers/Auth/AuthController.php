<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Girdiğiniz e-posta veya şifre hatalı.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Rol tabanlı yönlendirme: admin panele, normal kullanıcı ana sayfaya gider.
        $destination = Auth::user()->isAdmin()
            ? route('admin.dashboard')
            : route('home');

        return redirect()->intended($destination);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
