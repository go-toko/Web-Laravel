<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.general.my-profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $id = Crypt::decrypt($id);

        // Get data
        $data = UserProfileModel::findOrFail($id);

        // Profile Picture handler
        if ($request->hasFile('picture')) {


            if ($data->picturePath &&  Storage::disk('s3')->exists($data->picturePath)) {
                Storage::disk('s3')->delete($data->picturePath);
            }

            $image = $request->file('picture');

            $ext = $image->getClientOriginalExtension();

            // Using S3 bucket AWS
            $filename = Auth::user()->userProfile->first_name . Auth::user()->userProfile->last_name . '_' . time() . '_' . Str::random(5) . '.' . $ext;
            $filepath = 'pp/' . $filename;
            $compressedImage = Image::make($image)
                ->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode($ext, 75);

            Storage::disk('s3')->put($filepath, $compressedImage->__toString());

            $object = Storage::disk('s3')->url($filepath);

            // Using local storage
            // $filename = time() . '-' . str_replace(' ', '-', Str::random(5));
            // $request->file('picture')->move(public_path('category/images'), $filename);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        // Database transaction
        try {
            DB::beginTransaction();

            // Update database
            $data->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'nickname' => $request->nickname,
                'phone' => $request->phone,
                'picturePath' => $request->file('picture') ? $filepath : $data->picturePath,
                'picture' => $request->file('picture') ? $object : $data->picture,
                'gender' => $request->gender,
                'birthdate' => isset($request->birthdate) ? Carbon::createFromFormat('d-m-Y', $request->birthdate)->format('Y-m-d') : null,
                'address' => $request->address,
            ]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::error('Error when update data to databases in user_profile, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('User profile has been updated from ' . Auth::user()->name);
        return response()->json(['status' => 1, 'msg' => 'Success update profile']);
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
