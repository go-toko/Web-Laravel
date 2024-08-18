<?php

namespace App\Http\Controllers\Owner\Products;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\RestockValidate;
use App\Models\ProductsModel;
use App\Models\RestockDetailModel;
use App\Models\RestockModel;
use App\Models\ShopModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RestockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $restock = RestockModel::with(['detail', 'supplier', 'shop'])->where(['shop_id' => $idShop])->get();
        return view('page.owner.restock.index', [
            'restock' => $restock,
            'status' => RestockModel::status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idShop = Crypt::decrypt(Session::get('active'));
        $products = ProductsModel::where(['shop_id' => $idShop, 'isActive' => true])->get();
        $supplier = SupplierModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->get();
        return view('page.owner.restock.add', [
            'products' => $products,
            'supplier' => $supplier,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestockValidate $request)
    {
        if (!$request->product || empty($request->product) || count($request->product) != count($request->quantity)) {
            return back()->with(['type' => 'error', 'error' => 'Produk harus di isi']);
        }
        $total = 0;
        foreach ($request->product as $key => $value) {
            $price_buy = $this->formatRupiahToNumber($request->price_buy[$key]);
            $quantity = $request->quantity[$key];
            $total += ((int)$price_buy * (int)$quantity);
        }
        $shop = ShopModel::where(['id' => Crypt::decrypt(Session::get('active'))])->first();

        // Saldo
        // if ($shop->balance < $total) {
        //     throw new CustomException('Saldo tidak cukup', 400);
        // }

        try {
            DB::beginTransaction();
            $restock = RestockModel::create([
                'shop_id' => $shop->id,
                'supplier_id' => $request->supplier,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date),
                'total' => $total,
            ]);
            foreach ($request->product as $key => $value) {
                $price_buy = $this->formatRupiahToNumber($request->price_buy[$key]);
                $price_sell = $this->formatRupiahToNumber($request->price_sell[$key]);
                RestockDetailModel::create([
                    'restock_id' => $restock->id,
                    'product_id' => $value,
                    'price_buy' => (int)$price_buy,
                    'quantity' => (int)$request->quantity[$key],
                    'price_sell' => (int)$price_sell,
                    'total' => (int)$price_buy * (int)$request->quantity[$key]
                ]);
            }

            // Saldo
            // $shop->update([
            //     'balance' => (int)$shop->balance - $total
            // ]);

            DB::commit();
            return redirect(route('owner.produk.restock.index'))->with(['type' => 'success', 'success' => 'Berhasil menambah restock produk']);
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($e instanceof CustomException) {
                $message = $e->getMessage();
            }
            return redirect(route('owner.produk.restock.index'))->with(['type' => 'error', 'error' => $message ?? 'Gagal menambah restock produk']);
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
        $id = Crypt::decrypt($id);
        $restock = RestockModel::with('detail.product', 'supplier', 'shop')->where(['id' => $id])->first();
        return view('page.owner.restock.show', [
            'restock' => $restock,
            'status' => RestockModel::status,
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
        $id = Crypt::decrypt($id);
        $idShop = Crypt::decrypt(Session::get('active'));
        $restock = RestockModel::with('detail.product', 'supplier', 'shop')->where(['id' => $id])->first();
        $products = ProductsModel::where(['shop_id' => $idShop, 'isActive' => true])->get();
        $supplier = SupplierModel::where(['user_id' => Auth::user()->id, 'isActive' => true])->get();
        return view('page.owner.restock.edit', [
            'data' => $restock,
            'products' => $products,
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestockValidate $request, $id)
    {
        if (!$request->product || empty($request->product) || count($request->product) != count($request->quantity)) {
            return back()->with(['type' => 'error', 'error' => 'Produk harus di isi']);
        }

        $id = Crypt::decrypt($id);
        $restock = RestockModel::with('detail.product', 'supplier', 'shop')->where(['id' => $id])->first();
        $total = 0;
        foreach ($request->product as $key => $value) {
            $price_buy = $this->formatRupiahToNumber($request->price_buy[$key]);
            $quantity = (int)$request->quantity[$key];
            $total += ((int)$quantity * (int)$price_buy);
        }
        $shop = ShopModel::where(['id' => Crypt::decrypt(Session::get('active'))])->first();

        // Saldo
        // if (((int)$shop->balance + (int)$restock->total - (int)$total) < 0) {
        //     throw new CustomException('Saldo tidak cukup', 400);
        // }

        try {
            // DONE: menyesuaikan quantity product dan produk yang akan diedit
            DB::beginTransaction();
            $restock->update([
                'supplier_id' => $request->supplier,
                'date' => Carbon::createFromFormat('d-m-Y', $request->date),
                'total' => $total,
                'description' => $request->description
            ]);
            foreach ($request->product as $key => $value) {
                $price_buy = (int)$this->formatRupiahToNumber($request->price_buy[$key]);
                $price_sell = (int)$this->formatRupiahToNumber($request->price_sell[$key]);
                $quantity = (int)$request->quantity[$key];
                RestockDetailModel::create([
                    'restock_id' => $restock->id,
                    'product_id' => $value,
                    'price_buy' => $price_buy,
                    'quantity' => $quantity,
                    'price_sell' => $price_sell,
                    'total' => $price_buy * $quantity
                ]);
            }

            // Saldo
            // $shop->update(['balance' => $total]);

            DB::commit();
            return redirect(route('owner.produk.restock.index'))->with(['type' => 'success', 'success' => 'Berhasil mengubah produk']);
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($e instanceof CustomException) {
                $message = $e->getMessage();
            }
            return redirect(route('owner.produk.restock.index'))->with(['type' => 'error', 'error' => $message ?? 'Gagal mengubah produk']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DONE: menghapus restock = mengurangi stock
        $id = Crypt::decrypt($id);
        $idShop = Crypt::decrypt(Session::get('active'));
        $shop = ShopModel::where(['id' => $idShop])->first();
        $restock = RestockModel::with('detail')->where(['id' => $id])->first();
        try {
            DB::beginTransaction();
            // $shop->update([
            //     'balance' => $shop->balance + $restock->total
            // ]);
            $restock->delete();
            DB::commit();
            return response()->json(['msg' => 'Berhasil menghapus restock']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['msg' => 'Gagal menghapus restock']);
        }
    }

    public function validasiData($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $restock = RestockModel::with([])->where(['id' => $id])->first();
            DB::beginTransaction();
            $restock->update([
                'status' => 'SIAP DITAMBAHKAN',
            ]);
            DB::commit();
            return response()->json(['title' => 'Berhasil!', 'type' => 'success', 'msg' => 'Berhasil validasi restock']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => 'Gagal!', 'type' => 'error', 'msg' => 'Gagal validasi restock']);
        }
    }

    public function tambahkanStok($id)
    {
        $id = Crypt::decrypt($id);
        $restock = RestockModel::with(['detail.product'])->where(['id' => $id])->first();
        try {
            DB::beginTransaction();
            foreach ($restock->detail as $detail) {
                $product = ProductsModel::where(['id' => $detail->product->id])->first();
                $product->update([
                    'price_buy' => (int)$detail->price_buy,
                    'quantity' => (int)$product->quantity + (int)$detail->quantity,
                    'price_sell' => (int)$detail->price_sell,
                ]);
            }
            $restock->update([
                'status' => 'SELESAI',
            ]);
            DB::commit();
            return response()->json(['title' => 'Berhasil!', 'type' => 'success', 'msg' => 'Berhasil menambahkan stok ke Produk']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => 'Gagal!', 'type' => 'error', 'msg' => 'Gagal menambahkan stok ke Produk']);
        }
    }

    public function batalkan($id)
    {
        $id = Crypt::decrypt($id);
        try {
            $restock = RestockModel::with([])->where(['id' => $id])->first();
            DB::beginTransaction();
            $restock->update([
                'status' => 'BATAL',
            ]);
            DB::commit();
            return response()->json(['title' => 'Berhasil!', 'type' => 'success', 'msg' => 'Berhasil membatalkan stok']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['title' => 'Gagal!', 'type' => 'error', 'msg' => 'Gagal membatalkan stok']);
        }
    }

    private function formatRupiahToNumber($value)
    {
        return implode('', explode('.', str_replace('Rp', '', $value)));
    }
}
