<?php

namespace App\Http\Controllers\Owner\People;

use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\SupplierValidate;
use App\Models\SupplierModel;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = SupplierModel::where(['user_id' => Auth::user()->id])->get()->sortByDesc('isActive');
        return view('page.owner.supplier.index', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.owner.supplier.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierValidate $request)
    {
        try {
            // dd($request);
            DB::beginTransaction();
            SupplierModel::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'description' => $request->description,
            ]);
            DB::commit();
            return redirect(route('owner.orang.pemasok.index'))->with(['type' => 'success', 'success' => 'Berhasil menambahkan pemasok']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with(['type' => 'error', 'error' => 'Gagal menambahkan pemasok']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $supplier = SupplierModel::where(['id' => $id])->first();
            return response()->json($supplier);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Something Wrong']);
        }
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
        $data = SupplierModel::where(['id' => $id])->first();
        return view('page.owner.supplier.add-edit', ['data' => $data]);
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
        if ($request->status || $request->status == '0') {
            $response = $this->updateStatus($request, $id);
            return $response;
        }

        $id = Crypt::decrypt($id);
        try {
            $supplier = SupplierModel::where(['id' => $id])->first();
            DB::beginTransaction();
            $supplier->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'description' => $request->description,
            ]);
            DB::commit();
            return redirect(route('owner.orang.pemasok.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah informasi supplier']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect(route('owner.orang.pemasok.index'))->with(['type' => 'error', 'error' => 'Berhasil mengubah informasi supplier']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $supplier = SupplierModel::where(['id' => $id])->first();
        try {
            DB::beginTransaction();
            $supplier->update([
                'isActive' => $request->status,
            ]);
            DB::commit();
            return response()->json(['title' => "Supplier $supplier->name", 'msg' => 'Berhasil merubah status supplier.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => "Supplier $supplier->name", 'msg' => 'Gagal merubah status supplier.']);
        }
    }

    public function reportPdf()
    {
        $suppliers = SupplierModel::where(['user_id' => Auth::user()->id])->get()->sortByDesc('isActive');

        $html = view('page.owner.supplier.report-pdf', ['suppliers' => $suppliers]);

        // pdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream(time() . '-laporan-supplier.pdf');
    }

    public function reportExcel()
    {
        $suppliers = SupplierModel::where(['user_id' => Auth::user()->id])->get()->sortByDesc('isActive');
        $view = view('page.owner.supplier.report-excel', ['suppliers' => $suppliers]);

        return Excel::download(new OwnerReportExport($view), time() . '-laporan-supplier.xlsx');
    }
}
