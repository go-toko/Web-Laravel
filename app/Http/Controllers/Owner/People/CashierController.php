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
        $cashiers = UserCashierModel::with(['user.userProfile'])->whereIn('shop_id', $listShopIdOwner)->get();
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
        try {
            DB::beginTransaction();
            $user =  User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3
            ]);
            UserCashierModel::create([
                'shop_id' => $request->shop,
                'user_id' => $user->id,
            ]);
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
    public function update(CashierValidate $request, $id)
    {
        $cashier = $this->cashierById($id);
        try {
            DB::beginTransaction();
            $cashier->update([
                'shop_id' => $request->shop_id,
            ]);
            DB::commit();
            return response()->json(['title' => "Kasir " . $cashier->user->userProfile->first_name, 'msg' => 'Berhasil merubah toko kasir.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => "Kasir " . $cashier->user->userProfile->first_name, 'msg' => 'Gagal merubah toko kasir.']);
        }
    }

    public function restore($id)
    {
        $cashier = $this->cashierById($id);
        try {
            DB::beginTransaction();
            $cashier->update(['isActive' => true]);
            DB::commit();
            return response()->json(['msg' => 'Berhasil mengaktifkan kasir.']);
        } catch (\Throwable $error) {
            DB::rollBack();
            return response()->json(['msg' => 'Gagal mengaktifkan kasir.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cashier = $this->cashierById($id);
        try {
            if (!$cashier) return response()->json(['msg' => 'Akun kasir tidak ditemukan. Silahkan coba lagi !']);
            $cashier->update(['isActive' => false]);

            return response()->json(['msg' => 'Berhasil menghapus akun kasir']);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Gagal menghapus akun kasir. Coba lagi !']);
        }
    }

    private function cashierById($id)
    {
        return UserCashierModel::with(['user.userProfile'])->where(['id' => Crypt::decrypt($id)])->first();
    }

    public function cashierByEmail($email)
    {
        return User::with(['userProfile', 'userCashier.shop'])->where(['email' => $email])->first();
    }
}
