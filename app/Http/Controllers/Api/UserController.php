<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'alamat' => 'nullable|string|max:255',
            'username' => 'nullable|string|unique:users,username,' . $id,
            'imgprofile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data pengguna
        if ($request->hasFile('imgprofile')) {
            // Hapus gambar lama jika ada
            if ($user->imgprofile) {
                Storage::delete($user->imgprofile);
            }

            // Simpan gambar baru
            $validated['imgprofile'] = $request->file('imgprofile')->store('profile-images');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Perbarui data yang diizinkan
        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}
