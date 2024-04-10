<?php

namespace App\Http\Controllers\Owner\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CashierValidate;
use App\Models\User;
use App\Models\UserCashierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $cashiers = UserCashierModel::where(['shop_id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])->select('id', 'username', 'name', 'birthDate', 'gender', 'picture', 'status', 'address', 'isActive', 'created_at', 'updated_at')->get();
        $status = ['Aktif', 'Resign', 'Keluar'];
        return view('page.owner.cashier.index', [
            'cashiers' => $cashiers,
            'status' => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.owner.cashier.add-edit');
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
            $name = str_replace(' ', '', Str::lower($request->username));
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '-' . Str::random() . '-' . $name . '.' . $ext;

                // Save to local storage 
                $file->move(public_path('images/cashier-profile'), $filename);

                // Compress and save to local storage
                $originalImagePath = public_path("images/cashier-profile/" . $filename);
                Image::make($originalImagePath)->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            } else {
                $filename = 'default-profile.png';
            }
            DB::beginTransaction();
            $user =  User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3
            ]);
            UserCashierModel::create([
                'shop_id' => Crypt::decrypt(Session::get('active')),
                'user_id' => $user->id,
                'username' => $name,
                'name' => $request->name,
                'birthDate' => Carbon::createFromFormat('d-m-Y', $request->birthDate)->format('Y-m-d'),
                'gender' => $request->gender,
                'picture' => $filename,
                'address' => $request->address,
            ]);
            DB::commit();
            return redirect(route('owner.orang.kasir.index'))->with(['type' => 'success', 'success' => 'Berhasil menambahkan kasir']);
        } catch (\Throwable $e) {
            # code...
            DB::rollBack();
            return back()->with(['type' => 'error', 'error' => 'Gagal menambahkan kasir']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cashier = $this->cashierById($id);
        return view('page.owner.cashier.add-edit', [
            'data' => $cashier
        ]);
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
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json(['title' => "Kasir $cashier->name", 'msg' => 'Berhasil merubah status kasir.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => "Kasir $cashier->name", 'msg' => 'Gagal merubah status kasir.']);
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
        return UserCashierModel::where(['id' => Crypt::decrypt($id)])->first();
    }

    public function cashierByUsername($username)
    {
        return UserCashierModel::with('shop')->where(['username' => $username, 'isActive' => true])->select('id', 'username', 'name', 'picture', 'created_at', 'gender', 'address', 'status', 'birthDate', 'shop_id')->first();
    }
}
