<?php

namespace App\Http\Controllers\Owner\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CashierValidate;
use App\Models\ShopModel;
use App\Models\User;
use App\Models\UserCashierModel;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listShopOwner = ShopModel::where(['user_id' => Auth::user()->id])->get();
        $listShopIdOwner = [];
        foreach ($listShopOwner as $shop) {
            array_push($listShopIdOwner, $shop->id);
        }
        $cashiers = UserCashierModel::distinct('user_id')->with(['user.userProfile'])->whereIn('shop_id', $listShopIdOwner)->select('user_id')->get();
        return view('page.owner.cashier.index', [
            'cashiers' => $cashiers,
            'shops' => $listShopOwner
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listShopOwner = ShopModel::where(['user_id' => Auth::user()->id])->get();
        return view('page.owner.cashier.add-edit', [
            'shops' => $listShopOwner
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashierValidate $request)
    {
        $shops = ShopModel::where(['user_id' => Auth::user()->id])->get();
        try {
            DB::beginTransaction();
            $user =  User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3
            ]);
            foreach ($shops as $shop) {
                UserCashierModel::create([
                    'shop_id' => $shop->id,
                    'user_id' => $user->id,
                    'isActive' => $request->shop == $shop->id ? true : false,
                ]);
            }
            UserProfileModel::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'nickname' => $request->nickname,
                'birthdate' => $request->birthDate ? Carbon::createFromFormat('d-m-Y', $request->birthDate)->format('Y-m-d') : null,
                'gender' => $request->gender,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);
            DB::commit();
            return redirect(route('owner.orang.kasir.index'))->with(['type' => 'success', 'success' => 'Berhasil menambahkan kasir']);
        } catch (\Throwable $e) {
            # code...
            DB::rollBack();
            dd($e);
            return back()->with(['type' => 'error', 'error' => 'Gagal menambahkan kasir']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrDeleteAkses(CashierValidate $request)
    {
        $userCashierId = $request->cashierId;
        $shopId = $request->shopId;
        $cashier = UserCashierModel::with(['user.userProfile'])->where(['user_id' => $userCashierId, 'shop_id' => $shopId])->first();
        $value = $request->value == 'true' ? true : false;
        try {
            DB::beginTransaction();
            if (!$cashier) {
                UserCashierModel::create([
                    'shop_id' => $shopId,
                    'user_id' => $userCashierId,
                    'isActive' => $value,
                ]);
            }
            $cashier->update([
                'isActive' => $value,
            ]);
            DB::commit();
            return response()->json(['title' => 'Berhasil!!', 'msg' => 'Berhasil memberi akses']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e;
            return response()->json(['title' => 'Gagal!!', 'msg' => 'Gagal memberi akses']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function cashierByEmail($email)
    {
        return User::with(['userProfile', 'userCashier.shop'])->where(['email' => $email])->first();
    }
}
