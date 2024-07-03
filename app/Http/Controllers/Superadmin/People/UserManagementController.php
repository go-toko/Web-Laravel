<?php

namespace App\Http\Controllers\Superadmin\People;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\ShopModel;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('last_seen', 'DESC')->get();
        return view('page.superadmin.people.user.index', [
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $user = User::with('shop')->where('id', $id)->first();

        $shop = ShopModel::with('product', 'product.brand', 'product.category')->where('user_id', $id)->paginate(1);

        if ($request->ajax()) {
            return response()->json($shop);
        }

        return view('page.superadmin.people.user.show', [
            'user' => $user,
            'shops' => $shop,
        ]);
    }

    public function reportPdf()
    {
        // Mendapatkan data user dari database
        $users = User::all();

        // Menghasilkan HTML dari view laporan_list_user.blade.php dengan menggunakan data user
        $html = view('page.superadmin.people.user.report', compact('users'));

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream(time() . 'laporan_list_user.pdf');
    }

    /**
     * Print detail user
     */
    public function reportDetailPdf($id)
    {
        $id = Crypt::decrypt($id);

        $user = User::where('id', $id)->first();
        $shops = ShopModel::with('user', 'product')->where('user_id', $id)->get();

        $html = view('page.superadmin.people.user.report-detail', [
            'user' => $user,
            'shops' => $shops,
        ]);

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream('detail ' . $user->userProfile->first_name . ' ' . $user->userProfile->last_name);
    }

    public function reportExcel()
    {
        return Excel::download(new UsersExport, 'laporan_list_users.xlsx');
    }
}
