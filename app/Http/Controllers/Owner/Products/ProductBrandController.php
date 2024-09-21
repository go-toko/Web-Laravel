<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exceptions\CustomException;
use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\BrandValidate;
use App\Models\ProductBrand;
use App\Models\ProductsModel;
use Dompdf\Dompdf;
use Google\Service\AdExchangeBuyerII\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->getBrands();
        return view('page.owner.products-brand.index', [
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
        return view('page.owner.products-brand.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandValidate $request)
    {
        $nameBrand = trim(strtolower($request->name));
        $brand = DB::table('products_brand')->whereRaw("LOWER(name) = ?", [$nameBrand])->first();
        try {
            if ($brand) {
                throw new CustomException('Merek sudah ada');
            }
            if (Session::has('active')) {
                $idShop = Crypt::decrypt(Session::get('active'));
                ProductBrand::create([
                    'user_id' => Auth::user()->id,
                    'shop_id' => $idShop,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            } else {
                ProductBrand::create([
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
            return back()->with(['error' => $message ?? 'Gagal menambahkan merek', 'type' => 'error']);
        }
        return redirect(route('owner.produk.merek.index'))->with(['success' => 'Berhasil menambahkan merek ✅', 'type' => 'success']);
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
        $id = Crypt::decrypt($id);
        $data = ProductBrand::findOrFail($id);
        return view('page.owner.products-brand.add-edit', [
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
    public function update(BrandValidate $request, $id)
    {
        $nameBrand = trim(strtolower($request->name));
        $brand = DB::table('products_brand')->whereRaw("LOWER(name) = ?", [$nameBrand])->first();
        try {
            if ($brand) {
                throw new CustomException("Merek dengan nama $request->name sudah ada");
            }
            $id = Crypt::decrypt($id);
            $data = ProductBrand::findOrFail($id);
            $data->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return back()->with(['type' => 'error', 'error' => $message ?? 'Gagal mengubah merek']);
        }
        return redirect(route('owner.produk.merek.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah merek']);
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
            $id = Crypt::decrypt($id);
            $data = ProductBrand::findOrFail($id);
            $data->update([
                'isActive' => false
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
        return response()->json(['status' => 'success']);
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        try {
            ProductBrand::where(['id' => $id])->update([
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
            $id = Crypt::decrypt($id);
            $products = ProductsModel::where(['brand_id' => $id])->get();
            $jmlProducts = $products->count();
            if ($jmlProducts > 0) throw new CustomException('Gagal menghapus. Merek sudah digunakan');

            $data = ProductBrand::findOrFail($id);
            $data->delete();
            return response()->json(['type' => 'success', 'title' => 'Berhasil!!', 'msg' => 'Berhasil menghapus merek']);
        } catch (\Throwable $th) {
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return response()->json(['title' => 'Gagal!!', 'type' => 'error', 'msg' => $message ?? 'Ada sesuatu yang salah. Coba lagi!!']);
        }
    }

    public function reportPdf()
    {
        $brands = $this->getBrands();
        $brands = $brands->sortByDesc('created_at');

        $html = view('page.owner.products-brand.report-pdf', ['brands' => $brands]);

        // Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream(time() . '-laporan-brand-produk.pdf');
    }

    public function reportExcel()
    {
        $brands = $this->getBrands();
        $brands = $brands->sortByDesc('created_at');

        $view = view('page.owner.products-brand.report-excel', ['brands' => $brands]);

        return Excel::download(new OwnerReportExport($view), time() . '-laporan-brand-produk.xlsx');
    }

    private function getBrands()
    {
        $brands = ProductBrand::where(['user_id' => Auth::user()->id, 'isParent' => true])->get();
        if (Session::has('active')) {
            $idShop = Crypt::decrypt(Session::get('active'));
            $brandsShop = ProductBrand::where(['user_id' => Auth::user()->id, 'shop_id' => $idShop])->get();
            $brands = $brands->merge($brandsShop);
        }
        return $brands;
    }
}
