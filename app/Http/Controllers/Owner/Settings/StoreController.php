<?php

namespace App\Http\Controllers\Owner\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreValidate;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\ShopModel;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $storeUser = ShopModel::where([
            ['user_id', $userId],
        ])->get();
        return view('page.owner.settings.store.index', [
            'stores' => $storeUser,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::all();

        return view('page.owner.settings.store.add-edit', [
            'provinces' => $provinces
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreValidate $request)
    {
        $request['province'] = Province::where('id', $request->province)->first()->name;
        $request['regency'] = Regency::where('id', $request->regency)->first()->name;
        $request['district'] = District::where('id', $request->district)->first()->name;
        $request['village'] = Village::where('id', $request->village)->first()->name;
        $request['user_id'] = Auth::user()->id;
        $request['balance'] = $request->balance ? implode('', explode('.', str_replace('Rp', '', $request->balance))) : null;

        try {
            ShopModel::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'village' => $request->village,
                'address' => $request->address,
                'balance' => $request->balance ?? 0,
            ]);
        } catch (\Throwable $e) {
            return back()->with(['error', 'Something wrong', 'type' => 'error']);
        }
        return redirect(route('owner.pengaturan.daftar-toko.index'))->with(['success' => 'Berhasil membuat toko baru', 'type' => 'success']);
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
        $id = Crypt::decrypt($id);
        $data = ShopModel::where(['id' => $id])->first();
        $provinces = Province::all();

        return view('page.owner.settings.store.add-edit', [
            'data' => $data,
            'provinces' => $provinces
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreValidate $request, $id)
    {
        $id = Crypt::decrypt($id);
        $dataStore = ShopModel::findOrFail($id);
        if ($request->province || $request->regency || $request->district || $request->village) {
            $request->validate([
                'province' => 'required',
                'regency' => 'required',
                'district' => 'required',
                'village' => 'required',
            ]);
            // dd($request->province, $request->regency, $request->district, $request->village, $request);
        }
        $request['province'] = (Province::where(['id' => $request->province])->first()->name) ?? $dataStore->province;
        $request['regency'] = (Regency::where(['id' => $request->regency])->first()->name) ?? $dataStore->regency;
        $request['district'] = (District::where(['id' => $request->district])->first()->name) ?? $dataStore->district;
        $request['village'] = (Village::where(['id' => $request->village])->first()->name) ?? $dataStore->village;
        // dd($request);
        try {
            $dataStore->update([
                'name' => $request->name,
                'description' => $request->description,
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'village' => $request->village,
                'address' => $request->address,
            ]);
        } catch (\Throwable $e) {
            return back()->with(['type' => 'error', 'error' => 'Something wrong']);
        }
        return redirect(route('owner.pengaturan.daftar-toko.index'))->with(['type' => 'success', 'success' => 'Successfully changed data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $store = ShopModel::findOrFail($id);
        try {
            $store->update([
                'isActive' => false
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error']);
        }
        return response()->json(['status' => 'success']);
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $store = ShopModel::findOrFail($id);
        try {
            DB::beginTransaction();
            $store->update([
                'isActive' => true
            ]);
            DB::commit();
            return response()->json(['msg' => 'Berhasil mengaktifkan toko kembali.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['msg' => 'Gagal. Coba lagi!']);
        }
    }
}
