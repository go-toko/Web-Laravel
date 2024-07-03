<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = $this->getDataSalesByFilter($request);
        $payment_methods = SalesModel::payment_method;
        $status = SalesModel::status;
        $displayStatus = SalesModel::display_status;
        return view('page.owner.sales.index', [
            'sales' => $sales,
            'payment_methods' => $payment_methods,
            'status' => $status,
            'displayStatus' => $displayStatus
        ]);
    }


    public function show($id)
    {
        $sale = $this->getSales(Crypt::decrypt($id));
        $status = SalesModel::status;
        $displayStatus = SalesModel::display_status;
        return view('page.owner.sales.show', [
            'sale' => $sale,
            'status' => $status,
            'displayStatus' => $displayStatus
        ]);
    }

    private function getDataSalesByFilter(Request $request)
    {
        $startDate = null;
        $endDate = Carbon::now()->format('Y-m-d');
        $payment_method = 'all';
        $status = 'all';

        $sales = SalesModel::with(['cashier.userProfile', 'detail.product'])
            ->where(['shop_id' => Crypt::decrypt(Session::get('active'))]);

        if ($request->query('payment_method') && $request->query('payment_method') != 'all') {
            $payment_method = $request->query('payment_method');
            $sales = $sales->where(['payment_method' => $payment_method]);
        }
        if ($request->query('status') && $request->query('status') != 'all') {
            $status = $request->query('status');
            $sales = $sales->where(['status' => $status]);
        }

        if ($request->query('endDate')) {
            $endDate = Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d');
        }
        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
            $sales = $sales->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $sales->get();
    }

    public function reportPdf(Request $request)
    {
        $sales = $this->getDataSalesByFilter($request)->sortByDesc('created_at');
        $html = view('page.owner.sales.report-pdf', [
            'sales' => $sales,
            'status' => SalesModel::status,
            'displayStatus' => SalesModel::display_status
        ]);

        // Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        // render pdf 
        $pdf->render();

        return $pdf->stream(time() . "-laporan-penjualan.pdf");
    }

    public function reportExcel(Request $request)
    {
        $sales = $this->getDataSalesByFilter($request)->sortByDesc('created_at');
        $view = view('page.owner.sales.report-excel', [
            'sales' => $sales,
            'status' => SalesModel::status,
            'displayStatus' => SalesModel::display_status
        ]);
        return Excel::download(new OwnerReportExport($view), time() . '-laporan-penjualan.xlsx');
    }

    private function getSales($id)
    {
        $sale = SalesModel::with('cashier.userProfile', 'detail.product', 'shop')->where(['id' => $id])->first();
        return $sale;
    }
}
