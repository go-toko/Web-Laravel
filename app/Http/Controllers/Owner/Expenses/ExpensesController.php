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
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensesValidate $request)
    {
        try {
            if ($request->hasFile('image')) {
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/nota'), $filename);
            } else {
                $filename = 'noimage.png';
            }
            // DONE: Conver format Rp. to number only
            // DONE: implement store balance reduction
            $idShop = Crypt::decrypt(Session::get('active'));

            $shop = ShopModel::where(['id' => $idShop])->first();
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            // Saldo
            // if ($shop->balance < $request->amount) {
            //     throw new CustomException('Saldo tidak cukup', 400);
            // }

            DB::beginTransaction();
            // $shop->update([
            //     'balance' => $shop->balance - $request->amount,
            // ]);

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensesValidate $request, $id)
    {
        try {
            // DONE: implement store balance adjustment 
            $expense = $this->getExpenseById($id);
            $shop = $this->getShopActive();

            // Convert Rp. format to number only 
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            // Saldo
            // if ($shop->balance + $expense->amount - $request->amount < 0) {
            //     throw new CustomException('Saldo tidak cukup untuk melakukan pengeditan pengeluaran ini. Silahkan cek saldo anda!');
            // }

            DB::beginTransaction();

            if ($request->hasFile('image')) {
                // Deleting old image
                if (File::exists(public_path('images/nota/' . $expense->image_nota))) {
                    File::delete(public_path('images/nota/' . $expense->image_nota));
                }
                $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('images/nota'), $filename);
                $expense->update([
                    'image_nota' => $filename
                ]);
            }
            // $shop->update([
            //     'balance' => $shop->balance + $expense->amount - $request->amount,
            // ]);

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
            if (!$data) return response()->json(["msg" => "Gagal menghapus pengeluaran. Coba lagi!!"]);

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
