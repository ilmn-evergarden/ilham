<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     * If the user has no profile yet, pass an empty Profile instance.
     */
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile ?? new Profile();

        return view('profile.edit', compact('profile'));
    }

    /**
     * Create or update the user's profile.
     * Uses updateOrCreate so the same route handles both first-time save and edits.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user    = $request->user();
        $data    = $request->validated();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('profiles/photos', 'public');
        }

        // Handle CV upload
        if ($request->hasFile('cv')) {
            // Delete the old CV if it exists
            if ($profile->cv) {
                Storage::disk('public')->delete($profile->cv);
            }
            $data['cv'] = $request->file('cv')->store('profiles/cvs', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
