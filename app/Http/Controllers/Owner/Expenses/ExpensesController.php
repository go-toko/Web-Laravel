<?php

namespace App\Http\Controllers\Owner\Expenses;

use App\Exceptions\CustomException;
use App\Exports\OwnerReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ExpensesValidate;
use App\Models\ExpensesCategoryModel;
use App\Models\ExpensesHistoryModel;
use App\Models\ExpensesModel;
use App\Models\ShopModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
        }
        $endDate = $request->query('endDate') ?
            Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d') :
            Carbon::now()->format('Y-m-d');
        $expenses = $request->query('startDate') ?
            ExpensesModel::with('category')
            ->whereBetween('date', [$startDate, $endDate])
            ->where(['isActive' => true, 'shop_id' => Crypt::decrypt(Session::get('active'))])
            ->get() :
            ExpensesModel::with('category')
            ->where(['isActive' => true, 'shop_id' => Crypt::decrypt(Session::get('active'))])
            ->get();

        return view('page.owner.expenses.index', [
            'expenses' => $expenses
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
            // DONE: Conver format Rp. to number only
            // DONE: implement store balance reduction
            $idShop = Crypt::decrypt(Session::get('active'));

            $shop = ShopModel::where(['id' => $idShop])->first();
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            if ($shop->balance < $request->amount) {
                throw new CustomException('Saldo tidak cukup', 400);
            }

            DB::beginTransaction();
            $shop->update([
                'balance' => $shop->balance - $request->amount,
            ]);

            $newExpense = ExpensesModel::create([
                'name' => Str::lower($request->name),
                'category_id' => $request->category,
                'shop_id' => $idShop,
                'description' => $request->description,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                'amount' => $request->amount,
            ]);
            ExpensesHistoryModel::create([
                'shop_id' => $idShop,
                'expense_id' => $newExpense->id,
                'category' => $newExpense->category->name,
                'name' => $newExpense->name,
                'description' => $newExpense->description,
                'amount' => $newExpense->amount,
                'date' => $newExpense->date,
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
    public function update(Request $request, $id)
    {
        try {
            // DONE: implement store balance adjustment 
            $expense = $this->getExpenseById($id);
            $expenseHistory = ExpensesHistoryModel::where('expense_id', $expense->id)->first();
            $shop = $this->getShopActive();

            // Convert Rp. format to number only 
            $request['amount'] = implode('', explode('.', str_replace('Rp', '', $request->amount)));

            if ($shop->balance + $expense->amount - $request->amount < 0) {
                throw new CustomException('Saldo tidak cukup untuk melakukan pengeditan pengeluaran ini. Silahkan cek saldo anda!');
            }
            DB::beginTransaction();
            $shop->update([
                'balance' => $shop->balance + $expense->amount - $request->amount,
            ]);

            // Save updated expense information
            $updatedExpense = $expense->update([
                'name' => Str::lower($request->name),
                'category_id' => $request->category,
                'description' => $request->description,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                'amount' => $request->amount,
            ]);
            if ($updatedExpense)
                $expenseHistory->update([
                    'name' => $expense->name,
                    'category' => $expense->category->name,
                    'description' => $expense->description,
                    'date' => $expense->date,
                    'amount' => $expense->amount,
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

            $data->update([
                'isActive' => false,
            ]);
            return response()->json(["msg" => "Pengeluaran berhasil dihapus."]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Gagal menghapus pengeluaran. Coba lagi!!"]);
        }
    }

    private function getCategories()
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $categories = ExpensesCategoryModel::where(['isActive' => true, 'isParent' => true])->get();
        if (Session::has('active')) {
            $categoriesShop = ExpensesCategoryModel::where(['shop_id' => $idShop, 'isActive' => true])->get();
            $categories = $categories->merge($categoriesShop);
        }
        return $categories;
    }

    private function getExpenseById($id)
    {
        return ExpensesModel::findOrFail(Crypt::decrypt($id));
    }

    private function getShopActive()
    {
        return ShopModel::where(['id' => Crypt::decrypt(Session::get('active')), 'isActive' => true])->first();
    }

    public function reportPdf(Request $request)
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
        }
        $endDate = $request->query('endDate') ?
            Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d') :
            Carbon::now()->format('Y-m-d');

        $expenses = $request->query('startDate') ?
            ExpensesModel::with('category')->whereBetween('date', [$startDate, $endDate])->where(['isActive' => true, 'shop_id' => Crypt::decrypt(Session::get('active'))])->get() :
            ExpensesModel::with('category')->where(['isActive' => true, 'shop_id' => $idShop])->get();

        $html = view('page.owner.expenses.report', ['expenses' => $expenses]);

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
        $idShop = Crypt::decrypt(Session::get('active'));
        if ($request->query('startDate')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->query('startDate'))->format('Y-m-d');
        }
        $endDate = $request->query('endDate') ?
            Carbon::createFromFormat('d-m-Y', $request->query('endDate'))->format('Y-m-d') :
            Carbon::now()->format('Y-m-d');

        $expenses = $request->query('startDate') ?
            ExpensesModel::with('category')->whereBetween('date', [$startDate, $endDate])->where(['isActive' => true, 'shop_id' => Crypt::decrypt(Session::get('active'))])->get() :
            ExpensesModel::with('category')->where(['isActive' => true, 'shop_id' => $idShop])->get();

        $view = view('page.owner.expenses.report-excel', [
            'expenses' => $expenses
        ]);
        return Excel::download(new OwnerReportExport($view), time() . '-laporan-pengeluaran.xlsx');
    }
}
