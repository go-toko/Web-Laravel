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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('page.auth.signin');
    }

    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
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
                } else if (!isset($userSubs)){
                    $finduser->update([
                        'isSubscribe' => false,
                    ]);
                }

                Auth::login($finduser);

                switch ($finduser->role_id) {
                    case 1:
                        return redirect()->intended('superadmin/dashboard');
                        break;
                    case 2:
                        return redirect()->intended('owner/dashboard');
                        break;
                    case 3:
                        return redirect()->intended('cashier/dashboard');
                        break;
                }
            } else {

                try {

                    DB::beginTransaction();

                    $newUser = User::create([
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'role_id' => 2,
                        'password' => encrypt('123456dummy'),
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
                } catch (Exception $th) {
                    DB::rollBack();
                    Log::error("Error when store data to databases in user registration with socialite, the error is: " . $th);
                    dd($th->getMessage());
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function loginCashier(Request $request)
    {
        try {
            $cashierUser = UserCashierModel::where(['shop_id' => $request->shop_id, 'username' => $request->username, 'password' => $request->password])->first();
            if (!$cashierUser) {
                return response()->json([
                    'status' => 0,
                    'error' => 'Authentication data is not valid',
                ]);
            }
            return redirect()->intended(route('cashier.dashboard'));
        } catch (\Throwable $th) {
            Log::error("Error when login " . $th);
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('active');
        return redirect(route('login'));
    }
}
