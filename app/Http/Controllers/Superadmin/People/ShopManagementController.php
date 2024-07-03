<?php

namespace App\Http\Controllers\Superadmin\People;

use App\Exports\ShopExport;
use App\Http\Controllers\Controller;
use App\Models\ShopModel;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class ShopManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ShopModel::with('user')->get();
        return view('page.superadmin.people.shop.index', [
            'data' => $data,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);

        $shop = ShopModel::with('product', 'user')->where('id', $id)->first();
        return view('page.superadmin.people.shop.show', [
            'shop' => $shop,
        ]);
    }

    public function reportPdf()
    {
        // Mendapatkan data shop dari database
        $shops = ShopModel::all();

        // Menghasilkan HTML dari view laporan_list_user.blade.php dengan menggunakan data shop
        $html = view('page.superadmin.people.shop.report', compact('shops'));

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream(time() . 'laporan_list_user.pdf');
    }

    public function reportExcel()
    {
        return Excel::download(new ShopExport, 'laporan_list_toko.xlsx');
    }

    public function reportDetailPdf($id)
    {
        $id = Crypt::decrypt($id);

        $shop = ShopModel::with('product')->where('id' , $id)->first();

        $html = view('page.superadmin.people.shop.report-detail', [
            'shop' => $shop,
        ]);

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream('detail toko ' . $shop->name);
    }
}
