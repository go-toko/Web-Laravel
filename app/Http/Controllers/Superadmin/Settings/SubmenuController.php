<?php

namespace App\Http\Controllers\Superadmin\Settings;

use App\Models\MenuModel;
use Illuminate\Support\Str;
use App\Models\SubMenuModel;
use Illuminate\Http\Request;
use App\Models\RoleMenuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmenuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = MenuModel::with('roleMenu.role')->where('id', $request->menu_id)->first();
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        $data = array_merge($request->all(), ['status' => 1, 'url' => strtolower($menu->roleMenu[0]->role->name) . '/' . Str::slug(strtolower($menu->name), '-') . '/' . Str::slug($request->name, '-')]);

        try {
            DB::beginTransaction();

            SubMenuModel::create($data);

            MenuModel::where('id', $request->menu_id)->first()->update([
                'url' => '#',
            ]);

            DB::commit();
        } catch (\Throwable$exception) {
            DB::rollback();
            Log::error('Error when store data to databases in menus management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('SubMenu has been created from user ' . Auth::user()->name . ' with menus name ' . $data['name']);
        return response()->json(['status' => 1, 'msg' => 'Success create the menu']);
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
        $menu = MenuModel::where('id', $request->menu_id)->first();
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        }

        $data = array_merge($request->all(), ['status' => 1, 'url' => strtolower($menu->roleMenu[0]->role->name) . '/' . Str::slug(strtolower($menu->name), '-') . '/' . Str::slug($request->name, '-')]);

        try {
            DB::beginTransaction();

            SubMenuModel::where('id', $id)->update([
                'name' => $data['name'],
                'url' => $data['url']
            ]);

            DB::commit();
        } catch (\Throwable$exception) {
            DB::rollback();
            Log::error('Error when store data to databases in menus management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('SubMenu has been updated from user ' . Auth::user()->name . ' with menus name ' . $data['name']);
        return response()->json(['status' => 1, 'msg' => 'Success create the menu']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = SubMenuModel::findOrFail($id);
            Log::alert('SubMenu has been deleted from user '. Auth::user()->name. ' with menus name' . $data->name);
            $data->delete();
            return response()->json(['status' => 'success']);
        } catch (\Throwable$th) {
            Log::error('Error when deleting data from menus management, the error is : \n' . $th);
            return response()->json(['status' => 'error']);
        }
    }
}
