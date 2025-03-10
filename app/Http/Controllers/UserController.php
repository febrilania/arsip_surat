<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin/user', compact('users'));
    }

    public function show($id){
        $user = User::findOrFail($id);
        return view('admin/detail-user', compact('user'));
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('admin/edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:8',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Update data user
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
    
        // Jika password diisi, update password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // Jika ada upload foto baru
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::exists($user->profile_photo)) {
                Storage::delete($user->profile_photo);
            }
    
            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile_photo', 'public');
            $user->profile_photo = "storage/" . $path;
        }
    
        // Simpan perubahan
        $user->save();
    
        return redirect()->route('users.admin.index')->with('success', 'User berhasil diperbarui.');
    }


    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success','data berhasil dihapus');
    }

}
