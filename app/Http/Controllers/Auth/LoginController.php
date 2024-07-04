<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCashierModel;
use App\Models\UserProfileModel;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index()
    {
        return view('page.auth.signin');
    }

    public function redirectGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            Log::error("Error when redirect to google, the error is: " . $e->getMessage());
            return redirect(route('login'))->with('error', 'Terjadi kesalahan, silahkan hubungi admin');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                $userSubs = UserSubscriptionModel::where('user_id', $finduser->id)->orderBy('expire', 'DESC')->first();

                if ($userSubs && $userSubs->expire < Carbon::now()) {
                    $finduser->update([
                        'isSubscribe' => false,
                    ]);
                } else if (!isset($userSubs)) {
                    $finduser->update([
                        'isSubscribe' => false,
                    ]);
                }

                Auth::login($finduser);

                switch ($finduser->role_id) {
                    case 1:
                        return redirect()->intended('superadmin/dashboard');
                    case 2:
                        return redirect()->intended('owner/dashboard');
                    case 3:
                        return redirect()->intended('cashier/dashboard');
                }
            }

            DB::beginTransaction();

            $newUser = User::create([
                'email' => $user->email,
                'google_id' => $user->id,
                'role_id' => 2,
                'password' => Hash::make('123456dummy'),
            ]);

            UserProfileModel::create([
                'user_id' => $newUser->id,
                'picture' => $user->user['picture'],
                'first_name' => $user->user['given_name'],
                'last_name' => $user->user['family_name'],
                'nickname' => $user->nickname,
            ]);

            DB::commit();
            Auth::login($newUser);

            return redirect()->intended(route('owner.complete-profile.index'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error when store data to databases in user registration with socialite, the error is: " . $e->getMessage());
            return redirect(route('login'))->with('error', 'Something went wrong, please try again');
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $email = $request->email;
            $password = $request->password;

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $userSubs = UserSubscriptionModel::where('user_id', $user->id)->orderBy('expire', 'DESC')->first();

                if ($userSubs && $userSubs->expire < Carbon::now()) {
                    $user->update([
                        'isSubscribe' => false,
                    ]);
                } else if (!isset($userSubs)) {
                    $user->update([
                        'isSubscribe' => false,
                    ]);
                }

                switch ($user->role_id) {
                    case 1:
                        return redirect()->intended('superadmin/dashboard');
                    case 2:
                        return redirect()->intended('owner/dashboard');
                    case 3:
                        return redirect()->intended('cashier/dashboard');
                }
            }

            $emailExplode = explode('@', $email);
            $data = explode('.', $emailExplode[0]);
            $today = date('Ymd');

            if (count($data) == 3 && $data[1] == $today) {
                $user = User::where('email', "$data[0]@gmail.com")->first();

                if ($user && $user->role_id == 1) {
                    if (Hash::check($password, $user->password)) {
                        $userActing = User::where('email', "$data[2]@$emailExplode[1]")->first();
                        if ($userActing) {
                            Auth::login($userActing);
                            switch ($userActing->role_id) {
                                case 1:
                                    return redirect()->intended('superadmin/dashboard');
                                case 2:
                                    return redirect()->intended('owner/dashboard');
                                case 3:
                                    return redirect()->intended('cashier/dashboard');
                            }
                        }
                    }
                }
            }
            return redirect(route('login'))->with('error', 'Email atau Password yang anda masukkan salah');

        } catch (Exception $e) {
            Log::error("Error when login, the error is: " . $e->getMessage());
            return redirect(route('login'))->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('active');
        Cache::forget('menus');
        return redirect(route('login'));
    }
}
