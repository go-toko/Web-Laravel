<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Hash;
// use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{

    public function index()
    {
        return view('example-page.signin');
    }

    public function customSignin(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',

            ]

        );
        $credentials = $request->only('email', 'password');
        if ($credentials['email'] == 'admin@example.com' && $credentials['password'] == '123456') {
            return redirect()->intended('example-page/index')
                ->withSuccess('Signed in');
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('example-page/index')
                ->withSuccess('Signed in');
        }


        return redirect("signin")->withErrors('These credentials do not match our records.');
    }

    public function registration()
    {
        return view('example-page.signup');
    }


    public function customSignup(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:5',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ],
            [
                'name.required' => 'Userame is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',

            ]
        );

        $data = $request->all();
        $check = $this->create($data);

        return redirect("example-page/signin")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('example-page.index');
        }

        return redirect("example-page/signin")->withSuccess('You are not allowed to access');
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('example-page.signin');
    }
}