<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MahasiswaService
{
    // Ambil semua mahasiswa dengan search & pagination
    public function getAllMahasiswa($search = null)
    {
        $query = User::where('role', 'mahasiswa');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    // Ambil mahasiswa by ID
    public function getMahasiswaById($id)
    {
        return User::where('role', 'mahasiswa')->findOrFail($id);
    }

    // Buat mahasiswa baru
    public function createMahasiswa($data)
    {
        return User::create([
            'nim' => $data['nim'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'mahasiswa',
            'angkatan' => $data['angkatan'],
            'jurusan' => $data['jurusan'],
        ]);
    }

    // Update data mahasiswa
    public function updateMahasiswa($id, $data)
    {
        $mahasiswa = $this->getMahasiswaById($id);
        
        $updateData = [
            'nim' => $data['nim'],
            'name' => $data['name'],
            'email' => $data['email'],
            'angkatan' => $data['angkatan'],
            'jurusan' => $data['jurusan'],
        ];
        
        // Update password jika diisi
        if (isset($data['password']) && $data['password']) {
            $updateData['password'] = Hash::make($data['password']);
        }
        
        return $mahasiswa->update($updateData);
    }

    // Hapus mahasiswa
    public function deleteMahasiswa($id)
    {
        $mahasiswa = $this->getMahasiswaById($id);
        return $mahasiswa->delete();
    }
}