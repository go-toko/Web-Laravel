<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exports\OwnerReportExport;
use App\Models\ProductsCategoryModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CategoryValidate;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductsCategoryController extends Controller
{
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
        try {
            if (Session::has('active')) {
                $idShop = Crypt::decrypt(Session::get('active'));
                ProductsCategoryModel::create([
                    'user_id' => Auth::user()->id,
                    'shop_id' => $idShop,
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                ]);
            } else {
                ProductsCategoryModel::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                    'isParent' => true,
                ]);
            }
        } catch (\Throwable $th) {
            return back()->with(['type' => 'error', 'error' => 'Something wrong']);
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
        try {
            $id = Crypt::decrypt($id);
            $data = ProductsCategoryModel::findOrFail($id);
            if ($request->images != null && Storage::disk('s3')->exists('images/category/' . $data->images)) {
                // Delete old images if exists 
                Storage::disk('s3')->delete('images/category/' . $data->images);

                // Upload new images
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                Storage::disk('s3')->put('images/category/' . $filename, file_get_contents($request->file('image')), ['visibility' => 'public']);

                $filename = Storage::disk('s3')->url('images/category/' . $filename);
            } elseif ($request->images == null) {
                $filename = $data->images;
            }

            $data->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'images' => $filename,
            ]);
        } catch (\Throwable $th) {
            return back()->with(['error' => 'Error when submit to system'], ['type' => 'error']);
        }
        return redirect(route('owner.produk.kategori.index'))->with(['success' => 'Success saving data 😎', 'type' => 'success']);
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
            if ($data->images && $data->images !== 'noimage.png' && Storage::disk('s3')->exists('images/category/' . $data->images)) {
                Storage::disk('s3')->delete('images/category/' . $data->images);
            }
            $data->update([
                'isActive' => false
            ]);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
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

    private function getCategory()
    {
        $categories = ProductsCategoryModel::where(['user_id' => Auth::user()->id, 'isActive' => true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            $categoriesShop = ProductsCategoryModel::where(['user_id' => Auth::user()->id, 'isActive' => true, 'shop_id' => $id])->get();
            $categories = $categories->merge($categoriesShop);
        }
        return $categories;
    }
}
