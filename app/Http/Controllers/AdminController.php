<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // ensure correct namespace

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            if (request('view') == 'users') {
                $users = User::all();
                return view('admin.dashboard', compact('users'));
            }
            return view('admin.dashboard');
        }
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }
}