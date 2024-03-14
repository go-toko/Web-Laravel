<?php

namespace App\Http\Controllers\Owner\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ProductsValidate;
use App\Models\ProductBrand;
use App\Models\ProductsCategoryModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = ProductsModel::where(['isActive' => true])->get();
        // if (Session::has('active')) {
        $idShops = Crypt::decrypt(Session::get('active'));
        $productsShop = ProductsModel::with('category', 'brand')->where(['shop_id' => $idShops, 'isActive' => true])->get();
        // $products = $products->merge($productsShop);
        $products = $productsShop;
        // }
        return view('page.owner.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getCategoryByShop();
        $brands = $this->getBrandByShop();
        return view('page.owner.products.add-edit', ['categories' => $categories, 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsValidate $request)
    {
        // dd($request);
        try {
            if ($request->hasFile('image')) {
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/products'), $filename);
            } else {
                $filename = 'noimage.png';
            }
            $name = Str::lower($request->name);
            // dd($request, $filename, $name);
            ProductsModel::create([
                'category_id' => $request->category,
                'brand_id' => $request->brand,
                'shop_id' => Crypt::decrypt(Session::get('active')),
                'name' => $name,
                'description' => $request->description,
                'sku' => $request->sku,
                'quantity' => $request->quantity,
                'price_buy' => $request->buying_price,
                'price_sell' => $request->selling_price,
                'images' => $filename,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['type' => 'error', 'error' => 'Something wrong']);
        }
        return redirect(route('owner.products.index'));
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
        $data = ProductsModel::where(['id' => Crypt::decrypt($id)])->first();
        $categories = $this->getCategoryByShop();
        $brands = $this->getBrandByShop();
        return view('page.owner.products.add-edit', [
            'categories' => $categories,
            'brands' => $brands,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(ProductsValidate $request, $id)
    {
        try {
            $productData = $this->getProductsById(Crypt::decrypt($id))->first();

            if ($request->hasFile('image')) {
                // Deleting old image
                if (File::exists(public_path('images/products/' . $productData->images))) {
                    File::delete(public_path('images/products/' . $productData->images));
                }
                // Store new image
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/products'), $filename);
                // dd($request);
                $productData->update([
                    'images' => $filename
                ]);
            }
            $productData->update([
                'category' => $request->category,
                'brand' => $request->brand,
                'name' => Str::lower($request->name),
                'sku' => $request->sku,
                'price_buy' => $request->buying_price,
                'price_sell' => $request->selling_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error when submit to system'], ['type' => 'error']);
        }
        return redirect(route('owner.products.index'))->with(['type' => 'success', 'success' => 'Success saving products']);
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
            $data = $this->getProductsById(Crypt::decrypt($id))->first();
            if (!$data) return response()->json(["msg" => "Something went wrong. Please try again"]);

            if ($data->images != 'noimages.png') {
                File::delete(public_path('images/products/' . $data->images));
            }
            $data->update([
                'isActive' => false,
            ]);
            return response()->json(["msg" => "Your product has been deleted."]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Something went wrong. Please try again"]);
        }
    }

    private function getCategoryByShop()
    {
        $categoryShop = ProductsCategoryModel::where(['shop_id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])->get();
        $categoryParent = ProductsCategoryModel::where(['isParent' => true, 'isActive' => true])->get();
        $category = $categoryShop->merge($categoryParent);
        return $category;
    }

    private function getBrandByShop()
    {
        $brandShop = ProductBrand::where(['shop_id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])->get();
        $brandParent = ProductBrand::where(['isParent' => true, 'isActive' => true])->get();
        $brand = $brandShop->merge($brandParent);
        return $brand;
    }

    private function getProductsById($id)
    {
        return ProductsModel::where(['id' => $id]);
    }
}
