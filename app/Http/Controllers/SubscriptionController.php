<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionTypeModel;
use App\Models\User;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;


class SubscriptionController extends Controller
{
    public function index()
    {
        $subs_type = SubscriptionTypeModel::where('isActive', 1)
            ->orderBy('price')
            ->orderBy('time')
            ->get();
        return view('page.subscription', [
            'subs_type' => $subs_type,
        ]);
    }

    public function add(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_data = UserSubscriptionModel::orderBy('expire', 'DESC')->first();
        $subs_type = SubscriptionTypeModel::find($request->id);
        $user = User::where('id', $user_id)->first();

        $time_now = Carbon::now();

        if (!$user_data) {
            $expire = $time_now->addMonths($subs_type->time);
            try {
                DB::beginTransaction();

                UserSubscriptionModel::create([
                    'subscription_types_id' => $subs_type->id,
                    'subscription_name' => $subs_type->name,
                    'subscription_price' => $subs_type->price,
                    'subscription_time' => $subs_type->time,
                    'user_id' => $user_id,
                    'status' => 'paid',
                    'expire' => $expire,
                ]);

                User::where('id', $user_id)->update([
                    'isSubscribe' => 1,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::debug("Fail to add or update the data of user subscription", ['error' => $th]);
            }
        } else if ($user_data && $user_data->expire > $time_now) {
            try {
                $expire = Carbon::parse($user_data->expire)->addMonths($subs_type->time);

                DB::beginTransaction();

                UserSubscriptionModel::create([
                    'subscription_types_id' => $subs_type->id,
                    'subscription_name' => $subs_type->name,
                    'subscription_price' => $subs_type->price,
                    'subscription_time' => $subs_type->time,
                    'user_id' => $user_id,
                    'status' => 'paid',
                    'expire' => $expire,
                ]);

                User::where('id', $user_id)->update([
                    'isSubscribe' => 1,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                Log::debug("Fail to add or update the data of user subscription", ['error' => $th]);
            }
        } else if ($user_data->expire < $time_now) {
            $expire = $time_now->addMonths($subs_type->time);
            try {
                DB::beginTransaction();

                UserSubscriptionModel::create([
                    'subscription_types_id' => $subs_type->id,
                    'subscription_name' => $subs_type->name,
                    'subscription_price' => $subs_type->price,
                    'subscription_time' => $subs_type->time,
                    'user_id' => $user_id,
                    'status' => 'paid',
                    'expire' => $expire,
                ]);

                User::where('id', $user_id)->update([
                    'isSubscribe' => 1,
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::debug("Fail to add or update the data of user subscription", ['error' => $th]);
            }
        }

        Log::info("Success add subs", [
            'user' => $user->id,
            'subs_type' => $subs_type->id,
        ]);
        return response()->json(['status' => 1, 'msg' => 'Thanks for subscribing']);
    }

    public function processPayment(Request $request)
    {
        $subs_type = SubscriptionTypeModel::find($request->id);

        // Mengatur konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Membuat pembayaran menggunakan Midtrans Snap
        $transaction = [
            'transaction_details' => [
                'order_id' => uniqid(), // Order ID yang unik
                'gross_amount' => $subs_type->price, // Jumlah pembayaran langganan
            ],
            'customer_details' => [
                'first_name' => Auth::user()->userProfile->first_name,
                'last_name' => Auth::user()->userProfile->last_name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->userProfile->phone,
            ],
            'item_details' => [
                [
                    'id' => $subs_type->id, // ID langganan
                    'price' => $subs_type->price,
                    'quantity' => 1,
                    'name' => $subs_type->name,
                ],
            ],
            'credit_card' => [
                'secure' => true,
            ],
        ];

        $snapToken = Snap::getSnapToken($transaction);

        // Redirect ke halaman pembayaran Midtrans
        return response()->json(['snapToken' => $snapToken]);
    }
}
