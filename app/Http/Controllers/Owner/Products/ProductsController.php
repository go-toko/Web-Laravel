<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exceptions\CustomException;
use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ProductsValidate;
use App\Http\Requests\Owner\SearchInProductsDatabase;
use App\Http\Requests\Owner\UpdateDiskonValidate;
use App\Models\ProductBrand;
use App\Models\ProductsCategoryModel;
use App\Models\ProductsDatabase;
use App\Models\ProductsModel;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idShops = Crypt::decrypt(Session::get('active'));
        $productsShop = ProductsModel::with('category', 'brand')->where(['shop_id' => $idShops])->get();
        $products = $productsShop;

        $categories = $this->getCategoryByShop();
        $brands = $this->getBrandByShop();

        if ($request->query('category') | $request->query('brand')) {
            $products = $this->filterByCategoryAndOrBrand($request, $products);
        }

        return view('page.owner.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands
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
        try {
            if ($request->hasFile('image')) {
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/products'), $filename);
            } else {
                $filename = 'noimage.png';
            }
            $name = $request->name;
            $request['buying_price'] =  implode('', explode('.', str_replace('Rp', '', $request->buying_price)));
            $request['selling_price'] =  implode('', explode('.', str_replace('Rp', '', $request->selling_price)));

            $category = ProductsCategoryModel::with([])->whereRaw("name = LOWER('$request->category')")->first();
            $brand = ProductBrand::with([])->whereRaw("name = LOWER('$request->brand')")->first();

            DB::beginTransaction();
            if (!$category) {
                $category = ProductsCategoryModel::create([
                    'name' => $request->category,
                    'user_id' => Auth::user()->id,
                    'isParent' => true,
                ]);
            }
            if (!$brand) {
                $brand = ProductBrand::create([
                    'name' => $request->brand,
                    'user_id' => Auth::user()->id,
                    'isParent' => true
                ]);
            }
            ProductsModel::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'shop_id' => Crypt::decrypt(Session::get('active')),
                'name' => $name,
                'description' => $request->description,
                'sku' => $request->sku,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'price_buy' => $request->buying_price,
                'price_sell' => $request->selling_price,
                'images' => $filename,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with(['type' => 'error', 'error' => 'Something wrong']);
        }
        return redirect(route('owner.produk.daftar-produk.index'))->with(['type' => 'success', 'success' => 'Berhasil menambah produk']);
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

                $productData->update([
                    'images' => $filename
                ]);
            }
            $request['buying_price'] =  implode('', explode('.', str_replace('Rp', '', $request->buying_price)));
            $request['selling_price'] =  implode('', explode('.', str_replace('Rp', '', $request->selling_price)));
            $category = ProductsCategoryModel::with([])->whereRaw("name = LOWER('$request->category')")->first();
            $brand = ProductBrand::with([])->whereRaw("name = LOWER('$request->brand')")->first();

            $productData->update([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => $request->name,
                'sku' => $request->sku,
                'price_buy' => $request->buying_price,
                'price_sell' => $request->selling_price,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error when submit to system'], ['type' => 'error']);
        }
        return redirect(route('owner.produk.daftar-produk.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah informasi produk']);
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
            if (!$data) return response()->json(["msg" => "Ada sesuatu yang salah. Coba lagi!"]);

            $data->update([
                'isActive' => false,
            ]);
            return response()->json(["msg" => "Produk anda berhasil dinonaktifkan."]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Ada sesuatu yang salah. Coba lagi!"]);
        }
    }

    public function checkSKU(Request $request)
    {
        $counter = 0;
        $padLength = 10 - strlen((string)$counter);
        $nameSku = str_pad($request->sku, $padLength, "0", STR_PAD_RIGHT);
        $newName = $nameSku . (string)$counter;
        while (ProductsModel::where('sku', $newName)->exists()) {
            $counter++;
            $padLength = 10 - strlen((string)$counter);
            $nameSku = str_pad($request->sku, $padLength, "0", STR_PAD_RIGHT);
            $newName = $nameSku . (string)$counter;
        }
        return $newName;
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

    private function filterByCategoryAndOrBrand(Request $request, $products)
    {
        if ($request->query('category')) {
            $category = ProductsCategoryModel::where(['id' => $request->query('category')])->first();
            $products = $request->query('category') == 'all' ? $products : $products->map(function ($item) use ($category) {
                if ($item->category_id == $category->id) return $item;
            })->filter();
        }
        if ($request->query('brand')) {
            $brandId = $request->query('brand');
            $products = $request->query('brand') == 'all' ? $products : $products->map(function ($item) use ($brandId) {
                if ($item->brand_id == $brandId) return $item;
            })->filter();
        }
        return $products;
    }

    public function reportPdf(Request $request)
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $products = ProductsModel::with('category', 'brand')->where(['shop_id' => $idShop, 'isActive' => true])->get();
        if ($request->query('category') || $request->query('brand')) {
            $products = $this->filterByCategoryAndOrBrand($request, $products);
        }

        $html = view('page.owner.products.report-pdf', ['products' => $products]);

        // Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        // Render file PDF
        $pdf->render();

        return $pdf->stream(time() . '-laporan-data-barang.pdf');
    }

    public function reportExcel(Request $request)
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $products = ProductsModel::with('category', 'brand')->where(['shop_id' => $idShop, 'isActive' => true])->get();
        if ($request->query('category') || $request->query('brand')) {
            $products = $this->filterByCategoryAndOrBrand($request, $products);
        }

        $view = view('page.owner.products.report-excel', ['products' => $products]);

        return Excel::download(new OwnerReportExport($view), time() . '-laporan-data-barang.xlsx');
    }

    public function getData($id)
    {
        $id = Crypt::decrypt($id);
        $product = ProductsModel::where(['id' => $id])->first();
        return $product;
    }

    public function updateDiskon(UpdateDiskonValidate $request, $id)
    {
        $idProduct = Crypt::decrypt($id);
        $product = ProductsModel::where(['id' => $idProduct])->first();
        $product->update([
            'discount' => $request->jumlahDiskon
        ]);
        return ['id' => $idProduct, 'diskon' => $request->jumlahDiskon];
    }

    public function restore($id)
    {
        try {
            $data = $this->getProductsById(Crypt::decrypt($id))->first();
            if (!$data) return response()->json(["msg" => "Ada sesuatu yang salah. Coba lagi!"]);
            $data->update([
                'isActive' => true,
            ]);
            return response()->json(["msg" => "Produk berhasil diaktifkan"]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Ada sesuatu yang salah. Coba lagi!"]);
        }
    }

    public function getProductsFromProductsDatabase(SearchInProductsDatabase $request)
    {
        $q = trim($request->sku);
        try {
            $dataProducts = ProductsDatabase::whereRaw("sku like LOWER('%$q%')")->get();
            $jmlData = $dataProducts->count();
            if ($jmlData == 0) {
                throw new CustomException('Data tidak ditemukan');
            }
            return response()->json(['status' => 'success', 'msg' => 'Berhasil mendapatkan data', 'data' => $dataProducts, 'jmlData' => $jmlData]);
        } catch (\Throwable $e) {
            $message = "Ada sesuatu yang salah. Coba lagi!";
            if ($e instanceof CustomException) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'msg' => $message]);
        }
    }

    public function getOneProductsFromProductsDatabase(SearchInProductsDatabase $request)
    {
        $q = trim($request->sku);
        try {
            $dataProducts = ProductsDatabase::where(['sku' => $q])->first();
            if (!$dataProducts) {
                throw new CustomException('Data tidak ditemukan');
            }
            return response()->json(['status' => 'success', 'msg' => 'Berhasil mendapatkan data', 'data' => $dataProducts]);
        } catch (\Throwable $e) {
            $message = "Ada sesuatu yang salah. Coba lagi!";
            if ($e instanceof CustomException) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'msg' => $message]);
        }
    }
}
