<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function login(): Response
    {
        return response()->view('user.login', [
            "title" => "Login"
        ]);
    }

    public function register(): Response
    {
        return response()->view('user.register');
    }

    public function doRegister(Request $request): RedirectResponse
    {
        $validatedData = $request->validate(
            [
                "username" => "required|max:255|unique:users",
                "email" => "required|max:255|email:dns|unique:users",
                "password" => "required|min:8"
            ]
        );

        User::create($validatedData);

        return redirect('/login');  
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $userInput = $request->input('user');
        $passwordInput = $request->input('password');

        // validate input
        if(empty($userInput) || empty($passwordInput)){

            return response()->view('user.login', [
                "title" => "Login",
                "error" => "User or Password are required"
            ]);
        }

        $users = User::all();

        $user = $users->where('username', '=', $userInput)->first();

        if($user == null){
            return response()->view('user.login', [
                "title" => "Login",
                "error" => "User not found"
            ]);
        }

        $user_id = $user->user_id;
        $username = $user->username;

        $userPassword = $user->password;

        if($userPassword == $passwordInput){
            $request->session()->put([
                'user_id' => $user_id,
                'username'=>$username
            ]);
            return redirect('/');
        }

        return response()->view('user.login', [
            "title" => "Login",
            "error" => "User or Password are wrong"
        ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user_id");
        return redirect('/');
    }
}
