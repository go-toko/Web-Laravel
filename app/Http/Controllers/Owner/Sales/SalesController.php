<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Models\SalesModel;
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

        return view('page.owner.sales.index', [
            'sales' => $sales
        ]);
    }


    public function show($id)
    {
        $sale = $this->getSales(Crypt::decrypt($id));
        return view('page.owner.sales.show', [
            'sale' => $sale
        ]);
    }

    private function getDataSalesByFilter(Request $request)
    {
        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
        }
        $endDate = $request->query('endDate') ?
            Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d') :
            Carbon::now()->format('Y-m-d');

        $sales = $request->query('startDate') ?
            SalesModel::with('cashier.userCashierProfile', 'detail.product')
            ->whereBetween('date', [$startDate, $endDate])
            ->where(['shop_id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])
            ->get() :
            SalesModel::with('cashier.userCashierProfile', 'detail.product')
            ->where(['shop_id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])
            ->get();
        return $sales;
    }

    public function reportPdf(Request $request)
    {
        $sales = $this->getDataSalesByFilter($request)->sortByDesc('date');
        $html = view(
            'page.owner.sales.report-pdf',
            ['sales' => $sales]
        );

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
        $sales = $this->getDataSalesByFilter($request)->sortByDesc('date');
        $view = view(
            'page.owner.sales.report-excel',
            ['sales' => $sales]
        );
        return Excel::download(new OwnerReportExport($view), time() . '-laporan-penjualan.xlsx');
    }


    private function getSales($id)
    {
        $sale = SalesModel::with('cashier', 'detail.product', 'shop.user.userProfile')->where(['id' => $id, 'isActive' => true])->first();
        return $sale;
    }
}
