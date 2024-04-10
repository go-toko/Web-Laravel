<?php

namespace App\Http\Controllers\Owner\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ExpensesCategoryValidate;
use App\Models\ExpensesCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ExpensesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ExpensesCategoryModel::where(['isActive' =>  true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            $categoriesExpensesOnShop = ExpensesCategoryModel::where(['isActive' => true, 'shop_id' => $id])->get();
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
        try {
            $request['name'] = Str::lower($request->name);
            if (Session::has('active')) {
                ExpensesCategoryModel::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'shop_id' => Crypt::decrypt(Session::get('active')),
                ]);
            } else {
                ExpensesCategoryModel::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'isParent' => true,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['type' => 'error', 'error' => 'Gagal menambahkan kategori']);
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
        try {
            ExpensesCategoryModel::where(['id' => Crypt::decrypt($id)])->update([
                'name' => Str::lower($request->name),
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['type' => 'error', 'error' => 'Gagal mengubah kategori']);
        }
        return redirect(route('owner.pengeluaran.kategori.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah kategori']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
}
