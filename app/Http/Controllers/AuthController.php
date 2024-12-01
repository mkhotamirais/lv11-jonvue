<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // sleep(1);

        // validate
        $fields = $request->validate([
            'avatar' => 'file|nullable|max:1000',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        // register
        $user = User::create($fields);
        // login
        Auth::login($user);
        // redirect
        return redirect()->route('dashboard')->with('greet', 'Welcome ' . $user->name);
    }
    public function login(Request $request)
    {
        // validate
        $field = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // login

        if (Auth::attempt($field, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        // redirect
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
