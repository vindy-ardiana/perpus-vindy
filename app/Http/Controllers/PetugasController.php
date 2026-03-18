<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengelola petugas.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $petugas = User::where('role', 'petugas')
            ->when($q, fn($query) => $query->where('name', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('petugas.index', compact('petugas', 'q'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambah.');
    }

    public function edit(User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $petugas->id,
        ];
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::defaults()];
        }
        $request->validate($rules);
        $data = ['name' => $request->name, 'email' => $request->email];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $petugas->update($data);
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diubah.');
    }

    public function destroy(User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }
        $petugas->delete();
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
