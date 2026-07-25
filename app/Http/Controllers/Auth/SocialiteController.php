<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class SocialiteController extends Controller
{
    // Melempar user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangkap data profil dari Google setelah user login
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Gunakan method getEmail(), bukan property ->email
            $registeredUser = User::where('email', $googleUser->getEmail())->first();

            if ($registeredUser) {
                // Jika sudah ada, pastikan ini akun tipe 'user' (SSO hanya untuk pengguna biasa)
                if (($registeredUser->role ?? 'user') !== 'user') {
                    return redirect()->route('login')->with('error', 'Login dengan Google hanya tersedia untuk akun pengguna biasa.');
                }

                // Update google_id jika perlu lalu login
                $registeredUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
                Auth::login($registeredUser);
            } else {
                // Jika belum pernah daftar sama sekali, buat akun baru otomatis
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, 
                    'role' => 'user' 
                ]);
                Auth::login($newUser);
            }

            // Redirect ke halaman home (publik) setelah berhasil login
            return redirect()->route('home')->with('success', 'Berhasil login menggunakan Google!');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}