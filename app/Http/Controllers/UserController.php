<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengelola user.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $users = User::where('role', 'user')
            ->when($q, fn($query) => $query->where('name', 'like', '%' . $q . '%')
                ->orWhere('email', 'like', '%' . $q . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('user-admin.index', compact('users', 'q'));
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'user') {
            abort(403, 'Hanya dapat menghapus user peminjam.');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
