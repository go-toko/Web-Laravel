<?php

namespace App\Http\Controllers\Owner\Sales;

use App\Http\Controllers\Controller;
use App\Models\ProductsCategoryModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Crypt::decrypt(Session::get('active'));
        $categories = ProductsCategoryModel::with('product')->where(['isActive' => true, 'shop_id' => $id])->get();
        $products = ProductsModel::with('category')->where(['isActive' => true, 'shop_id' => $id])->get();
        return view('page.owner.sales.pos.index', [
            'categories' => $categories,
            'products' => $products,
        ]);
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
        try {
            foreach ($request->json() as $value) {
                $product = ProductsModel::find($value['id']);
                
                DB::beginTransaction();

                $product->update([
                    'quantity' => $product->quantity - $value['quantity']
                ]);

                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('error', ['message' => $th]);
        }
        return response()->json(['status' => 1, 'msg' => 'Success checkout the item, the quantity will be']);
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
