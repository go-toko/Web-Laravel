<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CompleteProfileValidate;
use App\Models\District;
use App\Models\Gender;
use App\Models\Province;
use App\Models\Regency;
use App\Models\ShopModel;
use App\Models\UserProfileModel;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CompleteProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::all();
        $userId = Auth::user()->id;
        $userProfile = UserProfileModel::where('user_id', $userId)->first();
        return view('page.owner.fill-profile.index', [
            'provinces' => $provinces,
            'userProfile' => $userProfile,
        ]);
    }

    public function getRegencies(Request $request)
    {
        $regencies = Regency::where('province_id', $request->id_province)->get();
        echo "<option value='null' selected disabled>-- Select --</option>";
        foreach ($regencies as $regency) {
            echo "<option value='$regency->id'>$regency->name</option>";
        }
    }

    public function getDistrict(Request $request)
    {
        $districts = District::where('regency_id', $request->id_regency)->get();
        echo "<option value='null' selected disabled>-- Select --</option>";
        foreach ($districts as $district) {
            echo "<option value='$district->id'>$district->name</option>";
        }
    }

    public function getVillage(Request $request)
    {
        $villages = Village::where('district_id', $request->id_district)->get();
        echo "<option value='null' selected disabled>-- Select --</option>";
        foreach ($villages as $village) {
            echo "<option value='$village->id'>$village->name</option>";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompleteProfileValidate $request, $idEncrypt)
    {
        $provinceName = Province::where('id', $request->provinceBusiness)->first()->name;
        $regencyName = Regency::where('id', $request->regencyBusiness)->first()->name;
        $districtName = District::where('id', $request->districtBusiness)->first()->name;
        $villageName = Village::where('id', $request->villageBusiness)->first()->name;
        $id = Crypt::decrypt($idEncrypt);
        // dd($request, Crypt::decrypt($idEncrypt), $provinceName, $regencyName, $districtName, $villageName);

        try {
            $userProfile = UserProfileModel::findOrFail($id);
            DB::beginTransaction();
            $userProfile->update([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'nickname' => $request->nickName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'birthdate' => $request->birthDate,
                'address' => $request->address,
            ]);
            ShopModel::create([
                'name' => $request->nameBusiness,
                'description' => $request->descriptionBusiness,
                'user_id' => $userProfile->user_id,
                'province' => $provinceName,
                'regency' => $regencyName,
                'district' => $districtName,
                'village' => $villageName,
                'address' => $request->addressBusiness,
            ]);
            // dd($userProfile, $update);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back();
        }
        return redirect(route('owner.dashboard'))->with('success', 'Success complete your profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
