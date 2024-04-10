<?php

namespace App\Http\Controllers\Owner\Settings;

use App\Http\Controllers\Controller;
use App\Models\ExpensesModel;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $latest_shop_id = ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        return view('page.owner.settings.cash-flow.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getCashFlow(Request $request)
    {
        $shop_id = $request->query('shop_id') ?? ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;
        if ($request->query('month')) {
            $month = $request->query('month');
            $month = strlen((string)$month) == 1 ? "0$month" : (string)$month;
        }

        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $expenses = $request->query('month') ?
            ExpensesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year-$month%")->get() :
            ExpensesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year%")->get();
        $amountExpense = $amounts;

        foreach ($expenses as $expense) {
            $index = $request->query('month') ? explode('-', $expense->date)[2] - 1 : explode('-', $expense->date)[1] - 1;
            $amountExpense[$index] += $expense->amount;
        }

        $sales = $request->query('month') ?
            SalesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year-$month%")->get() :
            SalesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year%")->get();
        $amountSales = $amounts;
        foreach ($sales as $sale) {
            $index = $request->query('month') ?
                explode('-', $sale->date)[2] - 1 :
                explode('-', $sale->date)[1] - 1;

            $amountSales[$index] += $sale->total;
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
        //
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
