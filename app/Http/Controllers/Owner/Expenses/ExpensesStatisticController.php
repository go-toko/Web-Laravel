<?php

namespace App\Http\Controllers\Owner\Expenses;

use App\Http\Controllers\Controller;
use App\Models\ExpensesCategoryModel;
use App\Models\ExpensesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpensesStatisticController extends Controller
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
        return view('page.owner.expenses-statistic.index', [
            'shops' => $shops,
            'latest_shop_id' => $latest_shop_id,
        ]);
    }

    public function getCategoryExpense(Request $request)
    {
        return response()->json(['category' => ExpensesCategoryModel::where(['shop_id' => $request->shop_id, 'isActive' => true])->get()]);
    }

    public function getExpenses(Request $request)
    {

        $shop_id = $request->query('shop_id') ?? ShopModel::where('user_id', Auth::user()->id)->latest()->first()->id;
        $year = $request->query('year') ?? Carbon::now()->year;
        if ($request->query('month')) {
            $month = $request->query('month');
            $month =  strlen((string)$month) == 1 ? "0$month" : (string)$month;
        }

        $categories = $request->query('category') && $request->query('category') != 'all' ?
            ExpensesCategoryModel::where(['id' => $request->query('category'), 'isActive' => true])->select('id', 'name', 'isActive')->get() :
            ExpensesCategoryModel::where(['shop_id' => $shop_id, 'isActive' => true])->select('id', 'name', 'isActive')->get();

        $expenses = $request->query('month') ?
            ExpensesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year-$month%")->get() :
            ExpensesModel::where(['shop_id' => $shop_id, 'isActive' => true])->where('date', 'LIKE', "$year%")->get();
        $data = [];
        $amounts = !$request->query('month') ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data["total"] = [
            'name' => 'Total Pengeluaran',
            'data' => $amounts
        ];
        foreach ($categories as $category) {
            $data["category$category->id"] = [
                'name' => Str::title($category->name),
                'data' => $amounts
            ];
        }
        foreach ($expenses as $expense) {
            $index = $request->query('month') ? explode('-', $expense->date)[2] - 1 : explode('-', $expense->date)[1] - 1;
            $data["total"]["data"][$index] += $expense->amount;
            foreach ($categories as $category) {
                $expense->category_id == $category->id ? $data["category$category->id"]["data"][$index] += $expense->amount : null;
            }
        }
        return response()->json(['expense' => $data]);
    }
}
