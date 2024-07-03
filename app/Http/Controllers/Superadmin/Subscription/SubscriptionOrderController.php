<?php

namespace App\Http\Controllers\Superadmin\Subscription;

use App\Exports\SubscriptionOrderExport;
use App\Http\Controllers\Controller;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionOrderController extends Controller
{
    public function index()
    {
        $data = UserSubscriptionModel::with('user')->get();
        return view('page.superadmin.subscription.order.index', compact('data'));
    }

    public function reportPdf()
    {
        // Mendapatkan data subscription type dari database
        $datas = UserSubscriptionModel::with('user')->get();

        // Menghasilkan HTML dari view laporan_list_user.blade.php dengan menggunakan data user
        $html = view('page.superadmin.subscription.order.report', compact('datas'));

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream(Carbon::now()->format('m-d-Y') . '_laporan_pembelian_langganan.pdf');
    }

    public function reportExcel()
    {
        return Excel::download(new SubscriptionOrderExport, Carbon::now()->format('m-d-Y') . '_laporan_pembelian_langganan.xlsx');
    }
}
