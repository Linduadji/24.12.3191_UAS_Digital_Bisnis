<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.organizer_login');
    }

    public function showRegister()
    {
        return view('auth.organizer_register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role !== 'organizer') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan akun organizer.']);
            }

            if (!$user->organization_id) {
                // Organizer harus terkait dengan organisasi
                Auth::logout();
                return back()->withErrors(['email' => 'Akun organizer belum terhubung dengan organisasi.']);
            }

            return redirect()->intended(route('organizer.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login')->with('success', 'Anda berhasil logout');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'organization_name' => ['required','string','max:255'],
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','confirmed','min:6'],
        ]);

        // create organization (owner_id will be set after user creation)
        $slugBase = \Illuminate\Support\Str::slug($data['organization_name']);
        $slug = $slugBase;
        $i = 1;
        while (\App\Models\Organization::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i++;
        }

        $organization = \App\Models\Organization::create([
            'name' => $data['organization_name'],
            'slug' => $slug,
        ]);

        // create user and attach to organization
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'organizer',
            'organization_id' => $organization->id,
        ]);

        // set owner on organization
        $organization->owner_id = $user->id;
        $organization->save();

        // login the new organizer
        Auth::login($user);

        return redirect()->route('organizer.dashboard')->with('success', 'Akun organizer berhasil dibuat. Selamat datang!');
    }
}
