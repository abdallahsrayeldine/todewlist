<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Plant;
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
        $user = $request->user();
        // $user->fill($request->validated());
        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $filePath = $request->file('profile_pic')->store('profilePics', 'public');
            // Update the user's profile picture path in the database
            $user->picpath = $filePath;
            // info($filePath);
        }
        if ($request->hasFile('profile_pic')) {
            // Delete old user picture if exists
            if ($user->profile_path) {
                $path = $user->profile_path;
                $user->profile_path = $request->file('profile_pic')->store('profilePics', 'public');
                Storage::disk('public')->delete($path);
            }
            // Store new user picture
            else {
                $path = $request->file('profile_pic')->store('profilePics', 'public');
                $user->profile_path = $path;
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

        // $plants = Plant::where('user_id', Auth::id())->get();

        // return Inertia::render('Dashboard', [
        //     'plants' => $plants,
        //     'picpath' => $user->picpath
        // ]);

        // dd($request->all());

        // if ($request->hasFile('file')) {
        //     $filePath = $request->file('file')->store('prof_pics', 'public');
        //     if (!is_null($request->user()->picpath)) {
        //         Storage::disk('public')->delete($request->user()->picpath);
        //     }
        //     $request->user()->picpath = $filePath;
        // }

        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();
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
