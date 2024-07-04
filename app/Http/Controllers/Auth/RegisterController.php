<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterController extends Controller
{
    public function index()
    {
        return view('page.auth.register');
    }


    public function register(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|unique:users',
                'name' => 'required|min:5',
                'password' => 'required|min:6',
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'email.unique' => 'Email is already registered',
                'name.required' => 'Name is required',
                'name.min' => 'Name must be at least 5 characters',
                'password.required' => 'Password is required',
            ],
        );

        try {
            DB::beginTransaction();

            $newUser = User::create([
                'email' => $request->email,
                'role_id' => 2,
                'password' => Hash::make($request->password),
            ]);

            $name = explode(' ', $request->name);
            $nickname = explode('@', $request->email);

            UserProfileModel::create([
                'user_id' => $newUser->id,
                'picture' => 'noimage.png',
                'first_name' => $name[0],
                'last_name' => count($name) > 1 ? join(' ', array_slice($name, 1)) : null,
                'nickname' => "user-" . $newUser->id . "-" . $nickname[0],
            ]);

            DB::commit();
            Auth::login($newUser);

            return redirect()->intended(route('owner.complete-profile.index'));
        } catch (Exception $e) {
            Log::error("Error when register, the error is: " . $e->getMessage());
            return redirect(route('register'))->with('error', 'Terjadi kesalahan, silahkan hubungi admin');
        }
    }

}
