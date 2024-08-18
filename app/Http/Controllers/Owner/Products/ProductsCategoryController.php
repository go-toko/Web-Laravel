<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exceptions\CustomException;
use App\Exports\OwnerReportExport;
use App\Models\ProductsCategoryModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CategoryValidate;
use App\Models\ProductsModel;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProductsCategoryController extends Controller
{
    private function getCategory()
    {
        $categories = ProductsCategoryModel::where(['user_id' => Auth::user()->id, 'isParent' => true])->get()->sortByDesc('isParent')->sortByDesc('isActive');
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            $categoriesShop = ProductsCategoryModel::where(['user_id' => Auth::user()->id, 'shop_id' => $id])->get()->sortByDesc('isParent')->sortByDesc('isActive');
            $categories = $categories->merge($categoriesShop);
        }
        return $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->getCategory();
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
        $nameCategory = trim(strtolower($request->name));
        $category = DB::table('products_category')->whereRaw("LOWER(name) = ?", [$nameCategory])->first();
        try {
            if ($category) {
                throw new CustomException('Kategori sudah ada');
            }
            if (Session::has('active')) {
                $idShop = Crypt::decrypt(Session::get('active'));
                ProductsCategoryModel::create([
                    'user_id' => Auth::user()->id,
                    'shop_id' => $idShop,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            } else {
                ProductsCategoryModel::create([
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
            return back()->with(['type' => 'error', 'error' => $message ?? 'Ada sesuatu yang salah']);
        }
        return redirect(route('owner.produk.kategori.index'))->with(['success' => "Success saving data ✅", 'type' => 'success']);
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
        $nameCategory = trim(strtolower($request->name));
        $category = DB::table('products_category')->whereRaw("LOWER(name) = ?", [$nameCategory])->first();
        try {
            if ($category) {
                throw new CustomException("Kategori dengan nama $request->name sudah ada");
            }
            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            $data->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return back()->with(['error' => $message ?? 'Gagal mengubah kategori'], ['type' => 'error']);
        }
        return redirect(route('owner.produk.kategori.index'))->with(['success' => 'Success saving data 😎', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsCategoryModel  $productsCategoryModel
     * @return \Illuminate\Http\Response
     */
    public function nonaktif($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            $data->update([
                'isActive' => false
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        try {
            ProductsCategoryModel::where(['id' => $id])->update([
                'isActive' => true,
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);;
        }
    }

    public function destroy($id)
    {
        try {
            $products = ProductsModel::where(['category_id' => Crypt::decrypt($id)])->get();
            $jmlProducts = $products->count();
            if ($jmlProducts > 0) throw new CustomException('Gagal menghapus. Kategori sudah digunakan');

            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            $data->delete();
            return response()->json(['type' => 'success', 'title' => 'Berhasil!!', 'msg' => 'Berhasil menghapus kategori']);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return response()->json(['title' => 'Gagal!!', 'type' => 'error', 'msg' => $message ?? 'Ada sesuatu yang salah. Coba lagi!!']);
        }
    }


    public function reportPdf()
    {
        $categories = $this->getCategory();
        $categories = $categories->sortByDesc('created_at');

        $html = view('page.owner.products-category.report-pdf', ['categories' => $categories]);

        // Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        // Render file pdf
        $pdf->render();

        return $pdf->stream(time() . '-laporan-kategori-produk.pdf');
    }

    public function reportExcel()
    {
        $categories = $this->getCategory();
        $categories = $categories->sortByDesc('created_at');

        $view = view('page.owner.products-category.report-excel', ['categories' => $categories]);

        return Excel::download(new OwnerReportExport($view), time() . '-laporan-ketegori-produk.xlsx');
    }
}
