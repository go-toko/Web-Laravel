<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Http\Controllers\Controller;
use App\Models\SalesModel;
use App\Models\ShopModel;
use App\Models\UserCashierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SalesStatisticController extends Controller
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
        return view('page.owner.sales-statistic.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getCashierOnShop(Request $request)
    {
        return response()->json(['cashier' => UserCashierModel::where(['shop_id' => $request->shop_id, 'isActive' => true])->get()]);
    }

    public function getSales(Request $request)
    {

        $shop_id = $request->query('shop_id') ?? ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;
        if ($request->query('month')) {
            $month = $request->query('month');
            $month =  strlen((string)$month) == 1 ? "0$month" : (string)$month;
        }

        $cashiers = $request->query('cashier') && $request->query('cashier') != 'all' ?
            UserCashierModel::where(['id' => $request->query('cashier'), 'isActive' => true])->get() :
            UserCashierModel::where(['shop_id' => $shop_id,  'isActive' => true])->get();

        $sales = $request->query('month') ?
            SalesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year-$month%")->get() :
            SalesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year%")->get();
        $data = [];
        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data["total"] = [
            'name' => 'Total Penjualan',
            'data' => $amounts
        ];
        foreach ($cashiers as $cashier) {
            $data["cashier$cashier->id"] = [
                'name' => Str::title($cashier->name),
                'data' => $amounts
            ];
        }
        foreach ($sales as $sale) {
            $index = $request->query('month') ?
                explode('-', $sale->date)[2] - 1 :
                explode('-', $sale->date)[1] - 1;
            $data["total"]["data"][$index] += $sale->total;
            foreach ($cashiers as $cashier) {
                $sale->cashier_id == $cashier->user_id ? $data["cashier$cashier->id"]["data"][$index] += $sale->total : null;
            }
        }
        return response()->json(['sales' => $data]);
    }
}
