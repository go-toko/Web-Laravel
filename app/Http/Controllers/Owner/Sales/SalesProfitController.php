<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Http\Controllers\Controller;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesProfitController extends Controller
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
        return view('page.owner.sales-profit.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getProfit(Request $request)
    {
        $shop_id = $request->query('shop_id') ?? ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;
        if ($request->query('month')) {
            $month = $request->query('month');
            $month =  strlen((string)$month) == 1 ? "0$month" : (string)$month;
        }

        $sales = $request->query('month') ?
            SalesModel::with('detail')->where('shop_id', $shop_id)->where('date', 'LIKE', "$year-$month%")->get() :
            SalesModel::with('detail')->where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year%")->get();
        $data = [];
        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data["total"] = [
            'name' => 'Total Penjualan',
            'data' => $amounts
        ];
        $data["profit"] = [
            'name' => 'Laba Penjualan',
            'data' => $amounts
        ];
        foreach ($sales as $sale) {
            $index = $request->query('month') ? explode('-', $sale->date)[2] - 1 : explode('-', $sale->date)[1] - 1;
            $data["total"]["data"][$index] += $sale->total;
            foreach ($sale->detail as $detail) {
                $data["profit"]['data'][$index] += ($detail->total_price - ($detail->quantity * $detail->buying_price));
            }
        }
        return response()->json(['profit' => $data]);
    }
}