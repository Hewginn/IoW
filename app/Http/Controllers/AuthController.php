<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
//    public function showRegister (){
//        return view('auth.register');
//    }

    public function showLogin (){
        return view('auth.login');
    }

//    public function register (Request $request){
//
//        $validated = $request->validate([
//            'username' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:8|confirmed',
//        ]);
//
//        $user = User::create($validated);
//
//        Auth::login($user);
//
//        return redirect()->route('home.index');
//    }

    public function login (Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(Auth::guard('web')->attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('home.index');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Incorrect email or password',
        ]);
    }

    public function showChangePassword (Request $request){
        return view('auth.change-password', [
            'title' => 'Change Password',
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}
