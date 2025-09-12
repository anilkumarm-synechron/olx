<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // ensure correct namespace
use App\Models\Ad;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            if (request('view') == 'users') {
                $users = User::all();
                return view('admin.dashboard', compact('users'));
            }
            if (request('view') == 'ads') {
                $ads = Ad::with('user')->latest()->paginate(25);
                return view('admin.dashboard', compact('ads'));
            }
            return view('admin.dashboard');
        }
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }
}