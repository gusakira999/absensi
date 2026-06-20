<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::where('role', 'mahasiswa');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $mahasiswas = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.mahasiswa.index', compact('mahasiswas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:users,nim|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'jurusan' => 'required|string|max:100',
        ]);

        try {
            User::create([
                'nim' => $validated['nim'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'mahasiswa',
                'angkatan' => $validated['angkatan'],
                'jurusan' => $validated['jurusan'],
            ]);
            
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan mahasiswa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nim' => 'required|max:20|unique:users,nim,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'angkatan' => 'required|integer|min:2000|max:2100',
            'jurusan' => 'required|string|max:100',
        ]);

        try {
            $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);
            
            $updateData = [
                'nim' => $validated['nim'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'angkatan' => $validated['angkatan'],
                'jurusan' => $validated['jurusan'],
            ];
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            $mahasiswa->update($updateData);
            
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);
            $mahasiswa->delete();
            
            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus mahasiswa: ' . $e->getMessage());
        }
    }
}