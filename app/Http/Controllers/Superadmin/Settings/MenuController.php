<?php

namespace App\Http\Controllers\Superadmin\Settings;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use App\Models\RoleMenuModel;
use App\Models\RolesModel;
use Dompdf\Dompdf;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.superadmin.settings.menu.index', [
            'roles' => RolesModel::with([
                'roleMenu' => function ($query) {
                    $query->orderBy('order', 'ASC');
                },
                'roleMenu.menu.subMenu',
            ])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = RolesModel::where('id', $request->role_id)->first();
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'icon' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        $data = array_merge($request->all(), ['status' => 1, 'url' => strtolower($role->name . '/' . Str::slug($request->name, '-'))]);
        try {
            DB::beginTransaction();

            $menu = MenuModel::create($data);

            RoleMenuModel::create([
                'role_id' => $request->role_id,
                'menu_id' => $menu->id,
            ]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::error('Error when store data to databases in menus management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('Menu has been created from user ' . Auth::user()->name . ' with menus name ' . $data['name']);
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
        $role = RolesModel::where('id', $request->role_id)->first();
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'icon' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        $data = array_merge($request->all(), ['status' => 1, 'url' => strtolower($role->name . '/' . Str::slug($request->name, '-'))]);

        try {
            DB::beginTransaction();

            MenuModel::where('id', $id)->update([
                'name' => $request->name,
                'url' => $data['url'],
                'icon' => $request->icon,
            ]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::error('Error when update data to databases in menus management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('Menu has been updated from user ' . Auth::user()->name . ' with menus name ' . $data['name']);
        return response()->json(['status' => 1, 'msg' => 'Success update the menu']);
    }

    public static function updateOrder(Request $request)
    {
        $order = $request->input('order');

        try {
            DB::beginTransaction();

            foreach ($order as $index => $itemId) {
                RoleMenuModel::where('id', $itemId)->update(['order' => $index + 1]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::alert('Sorting menu fail with error ' . $th);
            return response()->json(['status' => 0, 'msg' => $th]);
        }

        return response()->json(['status' => 1, 'msg' => 'Success sort menu, please reload to see the update']);
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
            $data = MenuModel::findOrFail($id);
            Log::alert('Menu has been deleted from user ' . Auth::user()->name . ' with menus name' . $data->name);
            $data->delete();
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            Log::error('Error when deleting data from menus management, the error is : \n' . $th->getMessage());
            return response()->json(['status' => 'error']);
        }
    }

    public function reportPdf()
    {
        // Mendapatkan data role beserta menu yang terhubung dari database
        $roles = RolesModel::with('roleMenu.menu.subMenu')->get();

        // Menghasilkan HTML dari view laporan_list_user.blade.php dengan menggunakan data user
        $html = view('page.superadmin.settings.menu.report', compact('roles'));

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream(time() . 'laporan_menu.pdf');
    }
}
