<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary as CloudinaryFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('user.profile');
    }

    /**
     * @return View
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:8',
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            $uploadedFile = $request->file('photo');

            $cloudinaryUpload = CloudinaryFacade::uploadApi()->upload($uploadedFile->getRealPath(), [
                'folder' => 'users',
                'resource_type' => 'image',
            ]);

            $user->photo()->create([
                'public_id' => $cloudinaryUpload['public_id'],
                'secure_url' => $cloudinaryUpload['secure_url'],
                'asset_id' => $cloudinaryUpload['asset_id'] ?? null,
                'resource_type' => $cloudinaryUpload['resource_type'] ?? 'image',
                'file_type' => $cloudinaryUpload['format'],
            ]);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', __('messages.profile.my_profile.registered_successfully'));
    }
}