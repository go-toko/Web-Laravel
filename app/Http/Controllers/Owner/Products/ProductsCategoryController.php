<?php

namespace App\Http\Controllers\Owner\Products;

use App\Models\ProductsCategoryModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CategoryValidate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductsCategoryModel::where(['isActive' => true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            $categoriesShop = ProductsCategoryModel::where(['isActive' => true, 'shop_id' => $id])->get();
            $categories = $categories->merge($categoriesShop);
        }
        return view('page.owner.products-category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.owner.products-category.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsCategoryModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidate $request)
    {
        try {
            if ($request->hasFile('image')) {
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/category'), $filename);
            } else {
                $filename = 'noimage.png';
            }

            if (Session::has('active')) {
                $idShop = Crypt::decrypt(Session::get('active'));
                ProductsCategoryModel::create([
                    'shop_id' => $idShop,
                    'name' => Str::lower($request->name),
                    'code' => $request->code,
                    'description' => $request->description,
                    'images' => $filename,
                ]);
            } else {
                ProductsCategoryModel::create([
                    'name' => Str::lower($request->name),
                    'code' => $request->code,
                    'description' => $request->description,
                    'images' => $filename,
                    'isParent' => true,
                ]);
            }
        } catch (\Throwable $th) {
            return back()->with(['type' => 'error', 'error' => 'Something wrong']);
        }
        return redirect(route('owner.products.category.index'))->with(['success' => "Success saving data ✅", 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsCategoryModel  $productsCategoryModel
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsCategoryModel $productsCategoryModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsCategoryModel  $productsCategoryModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = ProductsCategoryModel::findOrFail($id);
        return view('page.owner.products-category.add-edit', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsCategoryModelRequest  $request
     * @param  \App\Models\ProductsCategoryModel  $productsCategoryModel
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValidate $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            if ($request->images != null) {
                // Delete old images if exists 
                if (File::exists(public_path('images/category/' . $data->images))) {
                    File::delete(public_path('images/category/' . $data->images));
                }
                // Upload new images
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/category'), $filename);
            } elseif ($request->images == null) {
                $filename = $data->images;
            }
            $data->update([
                'name' => Str::lower($request->name),
                'code' => $request->code,
                'description' => $request->description,
                'image' => $filename,
            ]);
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error when submit to system'], ['type' => 'error']);
        }
        return redirect(route('owner.products.category.index'))->with(['success' => 'Success saving data 😎', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsCategoryModel  $productsCategoryModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            if ($data->images && $data->images !== 'noimage.png') {
                if (File::exists(public_path('images/category/' . $data->images))) {
                    File::delete(public_path('images/category/' . $data->images));
                }
            }
            $data->update([
                'isActive' => false
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }
}
