<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ExpensesModel;
use App\Models\ProductsModel;
use App\Models\SalesModel;
use App\Models\ShopModel;
use App\Models\SupplierModel;
use App\Models\UserCashierModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $shops = ShopModel::where([['user_id', $userId], ['isActive', true]])->orderBy('created_at', 'desc');
        if (Session::has('active')) {
            $shop_id = Crypt::decrypt(Session::get('active'));
            $total_cashier = UserCashierModel::where(['shop_id' => $shop_id, 'isActive' => true])->get()->count();
            $total_supplier = SupplierModel::where(['user_id' => $userId, 'isActive' => true])->get()->count();
            $total_product = ProductsModel::where(['shop_id' => $shop_id, 'isActive' => true])->get()->count();
            $total_expense = ExpensesModel::where(['shop_id' => $shop_id])->get()->count();
            return view('page.owner.index', [
                'shopOwner' => ShopModel::where(['id' => $shop_id])->firstOrFail(),
                'totalCashier' => $total_cashier,
                'totalSupplier' => $total_supplier,
                'totalProduct' => $total_product,
                'totalExpense' => $total_expense
            ]);
        }
        if ($request->query('search')) {
            $queries = $request->query('search');
            $queries = explode(' ', trim($queries));
            $queries = array_map(function ($q) {
                return "name like lower('%$q%')";
            }, $queries);
            $queries = join(" OR ", $queries);
            $shops = DB::table('shops')
                ->whereRaw("isActive = ? and user_id = ? and ($queries)", [true, $userId])
                ->orderByRaw('created_at DESC');
        }
        return view('page.owner.index', [
            'shops' => $shops->get()
        ]);
    }

    public function setSession($id)
    {
        $name = ShopModel::where(['id' => Crypt::decrypt($id)])->first()->name;
        Session::put('active', $id);
        Session::put('name', $name);
        return redirect(route('owner.dashboard'));
    }

    public function getExpenses(Request $request)
    {
        $dateNow = Carbon::now();
        $shop_id = Crypt::decrypt(Session::get('active'));
        $year = $dateNow->year;
        $month = $request->query('month') ?? $dateNow->month;
        $month = strlen((string)$month) == 1 ? "0$month" : (string)$month;
        $amounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $expenses = ExpensesModel::where(['shop_id' => $shop_id])->whereYear('date', $year)->whereMonth('date', $month);

        $data = [];
        $data["total"] = [
            'name' => 'Pengeluaran',
            'data' => $amounts
        ];

        foreach ($expenses->get() as $expense) {
            $date = Carbon::createFromFormat('Y-m-d', $expense->date);
            $index = $date->day - 1;
            $data["total"]["data"][$index] += $expense->amount;
        }

        return response()->json(['expense' => $data]);
    }

    public function getSales(Request $request)
    {
        $dateNow = Carbon::now();
        $shop_id = Crypt::decrypt(Session::get('active'));
        $year = $dateNow->year;
        $month = $request->query('month') ?? $dateNow->month;
        $month = strlen((string)$month) == 1 ? "0$month" : (string)$month;
        $amounts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $sales = SalesModel::where(['shop_id' => $shop_id])->whereYear('created_at', $year)->whereMonth('created_at', $month);

        $data = [];
        $data["total"] = [
            'name' => 'Total Penjualan',
            'data' => $amounts
        ];

        foreach ($sales->get() as $sale) {
            $date = Carbon::create($sale->created_at);
            $index = $date->day - 1;
            $data["total"]["data"][$index] += $sale->total_bill;
        }

        return response()->json(['sales' => $data]);
    }

    public function deleteSession()
    {
        Session::forget('active');
        Session::forget('name');
        return redirect(route('owner.dashboard'));
    }
}
