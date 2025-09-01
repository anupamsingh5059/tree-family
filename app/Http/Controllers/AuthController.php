<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
class AuthController extends Controller
{
     // ---------- Registration ----------
    public function showRegister() {
        return view('admin.register');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role_as' => 'admin', // default role
        ]);

        Auth::login($user);

        return response()->json(['status'=>true, 'message'=>'Registration successful']);
    }


  // Show login form
    public function adminlogin() {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    // Handle AJAX login
    public function postLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ]);
    }

public function logout() {

        Session::flush();

        Auth::logout();

  

        // return Redirect('login');
   return redirect()->route('admin.login'); // <-- Route name must exist
    }
    
}
