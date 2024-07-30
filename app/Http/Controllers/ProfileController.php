<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // dd($request->all());
        $user = $request->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // Delete old user picture if exists
            if ($user->picpath) {
                $path = $user->picpath;
                if ($path !== "pic.png") {
                    $user->picpath = $request->file('profile_pic')->store('profilePics', 'public');
                    Storage::disk('public')->delete($path);
                } else {
                    $user->picpath = $request->file('profile_pic')->store('profilePics', 'public');
                }
            } // Store new user picture
            else {
                $user->picpath = $request->file('profile_pic')->store('profilePics', 'public');
            }
        }

        // Clear email verification if email is updated
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($request->filled('current_password') || $request->filled('password') || $request->filled('password_confirmation')) {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->save();
        return back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
