<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::where('role', 'dosen');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nidn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $dosens = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.dosen.index', compact('dosens', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|unique:users,nidn|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'program_studi' => 'required|string|max:100',
        ]);

        try {
            User::create([
                'nidn' => $validated['nidn'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'dosen',
                'program_studi' => $validated['program_studi'],
            ]);
            
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Dosen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan dosen: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dosen = User::where('role', 'dosen')->findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nidn' => 'required|max:20|unique:users,nidn,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'program_studi' => 'required|string|max:100',
        ]);

        try {
            $dosen = User::where('role', 'dosen')->findOrFail($id);
            
            $updateData = [
                'nidn' => $validated['nidn'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'program_studi' => $validated['program_studi'],
            ];
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            $dosen->update($updateData);
            
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil diupdate!');
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
            $dosen = User::where('role', 'dosen')->findOrFail($id);
            $dosen->delete();
            
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Dosen berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus dosen: ' . $e->getMessage());
        }
    }
}
