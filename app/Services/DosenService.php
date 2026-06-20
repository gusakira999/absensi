<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DosenService
{
    // Ambil semua dosen dengan search & pagination
    public function getAllDosen($search = null)
    {
        $query = User::where('role', 'dosen');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nidn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    // Ambil dosen by ID
    public function getDosenById($id)
    {
        return User::where('role', 'dosen')->findOrFail($id);
    }

    // Buat dosen baru
    public function createDosen($data)
    {
        return User::create([
            'nidn' => $data['nidn'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'dosen',
            'program_studi' => $data['program_studi'],
        ]);
    }

    // Update data dosen
    public function updateDosen($id, $data)
    {
        $dosen = $this->getDosenById($id);
        
        $updateData = [
            'nidn' => $data['nidn'],
            'name' => $data['name'],
            'email' => $data['email'],
            'program_studi' => $data['program_studi'],
        ];
        
        // Update password jika diisi
        if (isset($data['password']) && $data['password']) {
            $updateData['password'] = Hash::make($data['password']);
        }
        
        return $dosen->update($updateData);
    }

    // Hapus dosen
    public function deleteDosen($id)
    {
        $dosen = $this->getDosenById($id);
        return $dosen->delete();
    }
}