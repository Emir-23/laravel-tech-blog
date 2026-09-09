<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * "Şifremi unuttum" formunu göster.
     */
    public function request(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Kullanıcının e-postasına sıfırlama bağlantısı gönder.
     * MAIL_MAILER=log ise bağlantı gerçekten mail atılmaz,
     * storage/logs/laravel.log dosyasına yazılır.
     */
    public function email(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.')
            : back()->withErrors(['email' => 'Bu e-posta adresiyle eşleşen bir kullanıcı bulunamadı.']);
    }

    /**
     * E-postadaki bağlantıdan gelen token ile şifre sıfırlama formunu göster.
     */
    public function reset(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Yeni şifreyi kaydet.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {
                // User modelindeki 'password' => 'hashed' cast'i sayesinde
                // burada elle Hash::make() çağırmaya gerek yok.
                $user->forceFill(['password' => $password])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Şifreniz güncellendi, yeni şifrenizle giriş yapabilirsiniz.')
            : back()->withErrors(['email' => 'Sıfırlama bağlantısı geçersiz veya süresi dolmuş.']);
    }
}
