<?php

namespace App\Http\Controllers\Owner\Expenses;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ExpensesCategoryValidate;
use App\Models\ExpensesCategoryModel;
use App\Models\ExpensesModel;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExpensesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ExpensesCategoryModel::where(['user_id' => Auth::user()->id, 'isParent' => true])->get();
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            $categoriesExpensesOnShop = ExpensesCategoryModel::where(['user_id' => Auth::user()->id, 'shop_id' => $id])->get();
            $categories = $categories->merge($categoriesExpensesOnShop);
        }
        return view('page.owner.expenses-category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.owner.expenses-category.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensesCategoryValidate $request)
    {
        $nameCategory = trim(strtolower($request->name));
        $category = DB::table('expenses_category')->whereRaw("LOWER(name) = ?", [$nameCategory])->first();
        try {
            if ($category) {
                throw new CustomException("Kategori dengan nama $request->name sudah ada");
            }
            $request['name'] = $request->name;
            if (Session::has('active')) {
                ExpensesCategoryModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'shop_id' => Crypt::decrypt(Session::get('active')),
                ]);
            } else {
                ExpensesCategoryModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'isParent' => true,
                ]);
            }
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return back()->with(['type' => 'error', 'error' => $message ?? 'Gagal menambahkan kategori']);
        }
        return redirect(route('owner.pengeluaran.kategori.index'))->with(['type' => 'success', 'success' => 'Berhasil menambahkan kategori']);
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
        $data = ExpensesCategoryModel::findOrFail(Crypt::decrypt($id));
        return view('page.owner.expenses-category.add-edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensesCategoryValidate $request, $id)
    {
        $nameCategory = trim(strtolower($request->name));
        $category = DB::table('expenses_category')->whereRaw("LOWER(name) = ?", [$nameCategory])->first();
        try {
            if ($category) {
                throw new CustomException("Kategori dengan nama $request->name sudah ada");
            }
            ExpensesCategoryModel::where(['id' => Crypt::decrypt($id)])->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return back()->with(['type' => 'error', 'error' => $message ?? 'Gagal mengubah kategori']);
        }
        return redirect(route('owner.pengeluaran.kategori.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah kategori']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nonaktif($id)
    {
        try {
            ExpensesCategoryModel::where(['id' => Crypt::decrypt($id)])->update([
                'isActive' => false,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error']);;
        }
    }

    public function restore($id)
    {
        try {
            ExpensesCategoryModel::where(['id' => Crypt::decrypt($id)])->update([
                'isActive' => true,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'error']);;
        }
    }

    public function destroy($id)
    {
        try {
            $expenses = ExpensesModel::where(['category_id' => Crypt::decrypt($id)])->get();
            $jmlExpenses = $expenses->count();
            if ($jmlExpenses > 0) {
                throw new CustomException('Gagal menghapus. Kategori sudah dipakai!!');
            }
            ExpensesCategoryModel::where(['id' => Crypt::decrypt($id)])->delete();
            return response()->json(['type' => 'success', 'title' => 'Berhasil!!', 'msg' => 'Berhasil menghapus kategori']);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return response()->json(['title' => 'Gagal!!', 'type' => 'error', 'msg' => $message ?? 'Ada sesuatu yang salah. Coba lagi!!']);;
        }
    }
}
