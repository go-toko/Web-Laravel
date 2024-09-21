<?php

namespace App\Http\Controllers\Owner\Expenses;

use App\Exceptions\CustomException;
use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ExpensesValidate;
use App\Models\ExpensesCategoryModel;
use App\Models\ExpensesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $expenses = $this->getDataByFilter($request);
        return view('page.owner.expenses.index', [
            'expenses' => $expenses->sortByDesc('date'),
            'status' => ExpensesModel::status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $categories = $this->getCategories();
        return view('page.owner.expenses.add-edit', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExpensesValidate $request)
    {
        try {
            if ($request->hasFile('image')) {
                $filename = "images/nota/" . round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                Storage::disk('s3')->put($filename, file_get_contents($request->file('image')));
            } else {
                $filename = 'noimage.png';
            }

            $idShop = Crypt::decrypt(Session::get('active'));
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            DB::beginTransaction();

            ExpensesModel::create([
                'name' => $request->name,
                'category_id' => $request->category,
                'shop_id' => $idShop,
                'description' => $request->description,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date),
                'amount' => $request->amount,
                'image_nota' => $filename,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($e instanceof CustomException) {
                $message = $e->getMessage();
            }
            return back()->with(['type' => 'error', 'error' => $message ?? 'Gagal menambahkan pengeluaran']);
        }
        return redirect(route('owner.pengeluaran.pengeluaran.index'))->with(['type' => 'success', 'success' => 'Berhasil menambahkan pengeluaran']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory
     */
    public function show($id)
    {
        $expense = $this->getExpenseById($id);
        $statusValue = ExpensesModel::status;
        return view('page.owner.expenses.show', [
            'expense' => $expense,
            'status' => $statusValue
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
        $categories = $this->getCategories();
        $expense = $this->getExpenseById($id);
        return view('page.owner.expenses.add-edit', [
            'data' => $expense,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExpensesValidate $request, $id)
    {
        try {
            // DONE: implement store balance adjustment 
            $expense = $this->getExpenseById($id);

            // Convert Rp. format to number only 
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if (Storage::disk('s3')->exists($expense->image_nota)) {
                    Storage::disk('s3')->delete($expense->image_nota);
                }

                $filename = "images/nota/" . round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                Storage::disk('s3')->put($filename, file_get_contents($request->file('image')));

                $expense->update([
                    'image_nota' => $filename
                ]);

            }

            // Save updated expense information
            $expense->update([
                'name' => $request->name,
                'category_id' => $request->category,
                'description' => $request->description,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date),
                'amount' => $request->amount,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th instanceof CustomException) {
                $message = $th->getMessage();
            }
            return back()->with(['type' => 'error', 'error' => $message ?? 'Gagal mengubah pengeluaran']);
        }
        return redirect(route('owner.pengeluaran.pengeluaran.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah pengeluaran']);
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
            $data = $this->getExpenseById($id);
            if (!$data)
                return response()->json(["msg" => "Gagal menghapus pengeluaran. Coba lagi!!"]);

            $data->delete();
            return response()->json(["msg" => "Pengeluaran berhasil dihapus."]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Gagal menghapus pengeluaran. Coba lagi!!"]);
        }
    }

    private function getCategories()
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $categories = ExpensesCategoryModel::where(['user_id' => Auth::user()->id, 'isActive' => true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $categoriesShop = ExpensesCategoryModel::where(['user_id' => Auth::user()->id, 'shop_id' => $idShop, 'isActive' => true])->get();
            $categories = $categories->merge($categoriesShop);
        }
        return $categories;
    }

    private function getExpenseById($id)
    {
        return ExpensesModel::with(['category', 'shop'])->findOrFail(Crypt::decrypt($id));
    }

    private function getShopActive()
    {
        return ShopModel::where(['id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])->first();
    }

    private function getDataByFilter(Request $request)
    {
        $startDate = null;
        $endDate = Carbon::now()->format('Y-m-d');
        $idShop = Crypt::decrypt(Session::get('active'));
        $expenses = ExpensesModel::with('category')->where(['shop_id' => $idShop]);
        if ($request->query('endDate')) {
            $endDate = Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d');
        }

        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
            $expenses = $expenses->whereBetween('date', [$startDate, $endDate]);
        }
        return $expenses->get();
    }

    public function reportPdf(Request $request)
    {
        $expenses = $this->getDataByFilter($request);
        $html = view('page.owner.expenses.report', [
            'expenses' => $expenses->sortByDesc('date')
        ]);

        // Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');

        // Render file PDF
        $pdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $pdf->stream(time() . "-laporan-pengeluaran.pdf");
    }

    public function reportExcel(Request $request)
    {
        $expenses = $this->getDataByFilter($request);
        $view = view('page.owner.expenses.report-excel', [
            'expenses' => $expenses->sortByDesc('date')
        ]);
        return Excel::download(new OwnerReportExport($view), time() . '-laporan-pengeluaran.xlsx');
    }

    public function updateStatus(ExpensesValidate $request, $id)
    {
        $expense = $this->getExpenseById($id);
        try {
            DB::beginTransaction();
            $expense->update([
                'status' => $request->status
            ]);
            DB::commit();
            $message = 'Berhasil menyelesaikan pengeluaran.';
            if ($request->status == 'BATAL') {
                $message = 'Berhasil membatalkan pengeluaran.';
            }
            return response()->json(['title' => 'Berhasil!!', 'type' => 'success', 'msg' => $message]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => 'Gagal!!', 'type' => 'error', 'msg' => 'Ada sesuatu yang salah. Coba lagi!!']);
        }
    }
}
