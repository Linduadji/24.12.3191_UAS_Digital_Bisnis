<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $organization = $user->organization;

        return view('organizer.profile.edit', compact('user', 'organization'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'organization_name' => 'required|string|max:255',
            'organization_website' => 'nullable|url|max:255',
            'organization_description' => 'nullable|string|max:1000',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if ($organization) {
            $organization->update([
                'name' => $data['organization_name'],
                'website' => $data['organization_website'],
                'description' => $data['organization_description'],
            ]);
        }

        // Handle password change when requested
        if (!empty($data['new_password'])) {
            if (empty($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Password sebelumnya tidak sesuai.'])->withInput();
            }

            $user->update(['password' => Hash::make($data['new_password'])]);
        }

        return redirect()->route('organizer.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
