<?php

namespace App\Services;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary as CloudinaryFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param User $user
     * @param Request $request
     * @return User
     */
    public function update(User $user, Request $request): User
    {
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

        return $user;
    }
}