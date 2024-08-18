<?php

namespace App\Http\Controllers\Owner\Settings;

use App\Http\Controllers\Controller;
use App\Models\ExpensesModel;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class CashFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = ShopModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->select('name', 'id')->get();
        $latest_shop_id = ShopModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->get()->sortByDesc('created_at')->first()->id;
        if (Session::has('active')) {
            $latest_shop_id = Crypt::decrypt(Session::get('active'));
        }
        return view('page.owner.settings.cash-flow.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getCashFlow(Request $request)
    {
        // init Value
        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        // init Parameter
        $shop_id = $request->query('shop_id') ?? ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;

        // init Result
        $expenses = ExpensesModel::where(['shop_id' => $shop_id])->whereYear('date', $year);
        $sales = SalesModel::where(['shop_id' => $shop_id])->whereYear('created_at', $year);
        $amountExpense = $amounts;
        $amountSales = $amounts;

        if ($request->query('month')) {
            $month = $request->query('month');
            $month = strlen((string)$month) == 1 ? "0$month" : (string)$month;
            $expenses = $expenses->whereMonth('date', $month);
            $sales = $sales->whereMonth('created_at', $month);
        }

        foreach ($expenses->get() as $expense) {
            $index = $request->query('month') ? explode('-', $expense->date)[2] - 1 : explode('-', $expense->date)[1] - 1;
            $amountExpense[$index] += $expense->amount;
        }

        foreach ($sales->get() as $sale) {
            $date = Carbon::create($sale->created_at);
            $index = $request->query('month') ?
                $date->day - 1 :
                $date->month - 1;
            $amountSales[$index] += $sale->total_bill;
        }

        return response()->json(
            [
                'expenses' => [
                    'name' => 'Total Pengeluaran',
                    'data' => $amountExpense
                ],
                'sales' => [
                    'name' => 'Total Penjualan',
                    'data' => $amountSales
                ]
            ]
        );
    }
}
