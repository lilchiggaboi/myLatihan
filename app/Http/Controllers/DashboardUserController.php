<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardUserController extends Controller
{
    public function index()
    {
        $data['dosen'] = DB::select("
            SELECT
                *
            FROM
                dosen
        ");
        
        return
            view('user.header', $data) .
            view('user.user', $data) .
            view('user.footer');
    }

    public function editProfile()
    {
        return view('user.edit_profile');
    }

    public function store(Request $request)
{
    // Validasi file gambar
    $request->validate([
        'profile_image' => 'required|mimes:png,jpeg,jpg|max:2048',
    ]);

    // Cek apakah session memiliki data user
    if (!session()->has('user')) {
        Log::error('User not found in session.');
        return redirect()->back()->withErrors(['error' => 'User not found in session.']);
    }

    // Ambil data user dari session
    $data = session('user')[0];

    // Pastikan 'id_user' ada dalam session
    if (!isset($data['id_user'])) {
        Log::error('id_user not found in session.');
        return redirect()->back()->withErrors(['error' => 'id_user not found in session.']);
    }

    // Ambil id_user dari data
    $idUser = $data['id_user'];

    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        $file_name = time() . '_' . $file->getClientOriginalName();

        try {
            // Simpan gambar di folder public/profile-images
            $filePath = $file->storeAs('profile-images', $file_name, 'public');

            // Update kolom profile_image di database
            $updated = DB::table('user')
                ->where('ID_USER', $idUser)
                ->update(['profile_image' => $file_name]);

            if ($updated) {
                // Update session data dengan gambar baru
                $data['profile_image'] = $file_name;
                session(['user' => [$data]]);
                Log::info('Profile image updated successfully for user ID: ' . $idUser);
                return redirect()->back()->with('success', 'Profile image updated successfully.');
            } else {
                Log::error('Failed to update profile image for user ID: ' . $idUser);
                return redirect()->back()->withErrors(['error' => 'Failed to update profile image.']);
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while updating profile image: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating profile image.']);
        }
    }

    Log::error('No profile image uploaded.');
    return redirect()->back()->withErrors(['error' => 'No profile image uploaded.']);
}
}
