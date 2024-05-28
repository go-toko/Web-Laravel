<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\BrandValidate;
use App\Models\ProductBrand;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
        try {
            if ($request->hasFile('image')) {
                $filename = "images/brand/" . round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $upload = Storage::disk('s3')->put($filename, file_get_contents($request->file('image')), 'public');

                if (!$upload) {
                    return back()->with(['error' => 'Gagal mengunggah gambar, Hubungi Admin', 'type' => 'error']);
                }

                // get url image
                $filename = Storage::disk('s3')->url($filename);
            } else {
                $filename = 'noimage.png';
            }

            if (Session::has('active')) {
                $idShop = Crypt::decrypt(Session::get('active'));
                ProductBrand::create([
                    'user_id' => Auth::user()->id,
                    'shop_id' => $idShop,
                    'name' => $request->name,
                    'description' => $request->description,
                    'images' => $filename,
                ]);
            } else {
                ProductBrand::create([
                    'user_id' => Auth::user()->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'images' => $filename,
                    'isParent' => true,
                ]);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with(['error' => 'Gagal menambahkan merek', 'type' => 'error']);
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
        try {
            $id = Crypt::decrypt($id);
            $data = ProductBrand::findOrFail($id);

            if ($request->image != null) {
                // Delete old images if exists 
                if ($data->image != 'noimage.png' && Storage::disk('s3')->exists("images/brand/" . $data->image)) {
                    Storage::disk('s3')->delete($data->images);
                }

                // Upload new images
                $filename = "images/brand/" . round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $upload = Storage::disk('s3')->put($filename, file_get_contents($request->file('image')), ['visibility' => 'public']);

                if (!$upload) {
                    return back()->with(['error' => 'Gagal mengunggah gambar, Hubungi Admin', 'type' => 'error']);
                }

                $filename = Storage::disk('s3')->url($filename);
            }


            $data->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'images' => $filename ?? $data->image,
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with(['type' => 'error', 'error' => 'Gagal mengubah merek']);
        }
        return redirect(route('owner.produk.merek.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah merek']);
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
            $id = Crypt::decrypt($id);
            $data = ProductBrand::findOrFail($id);
            // delete image if exists
            if ($data->images != 'noimage.png') {
                if (File::exists(public_path('images/brand/' . $data->images))) {
                    File::delete(public_path('images/brand/' . $data->images));
                }
            }
            $data->update([
                'isActive' => false
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
        return response()->json(['status' => 'success']);
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
        $brands = ProductBrand::where(['user_id' => Auth::user()->id, 'isActive' => true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $idShop = Crypt::decrypt(Session::get('active'));
            $brandsShop = ProductBrand::where(['user_id' => Auth::user()->id, 'shop_id' => $idShop, 'isActive' => true])->get();
            $brands = $brands->merge($brandsShop);
        }

        return $brands;
    }
}
