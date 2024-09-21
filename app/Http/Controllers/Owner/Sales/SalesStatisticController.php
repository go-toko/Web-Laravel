<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Http\Controllers\Controller;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

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
        $latest_shop_id = ShopModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->get()->sortByDesc('created_at')->first()->id;
        if (Session::has('active')) {
            $latest_shop_id = Crypt::decrypt(Session::get('active'));
        }
        return view('page.owner.sales-statistic.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getSales(Request $request)
    {
        $shop_id = $request->query('shop_id') ?? ShopModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->get()->sortByDesc('created_at')->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;
        $sales = SalesModel::where(['shop_id' => $shop_id])->whereYear('created_at', $year);

        if ($request->query('month')) {
            $month = $request->query('month');
            $month =  strlen((string)$month) == 1 ? "0$month" : (string)$month;
            $sales = $sales->whereMonth('created_at', $month);
        }

        $data = [];
        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data["total"] = [
            'name' => 'Total Penjualan',
            'data' => $amounts
        ];

        foreach ($sales->get() as $sale) {
            $date = Carbon::create($sale->created_at);
            $index = $request->query('month') ?
                $date->day - 1 :
                $date->month - 1;

            $data["total"]["data"][$index] += $sale->total_bill;
        }
        return response()->json(['sales' => $data]);
    }
}
