<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use App\Models\MerchantPaymentWithdrawal;
use App\Models\ShopModel;
use Illuminate\Support\Facades\DB;

class PaymentWithdrawalController extends Controller
{
    public function index()
    {
        $data = MerchantPaymentWithdrawal::with('shop')->get();

        return view('page.superadmin.payment.withdrawal.index', compact('data'));
    }

    public function edit($id, $status)
    {
        try {
            DB::beginTransaction();
            $payment = MerchantPaymentWithdrawal::find($id);
            $payment->update([
                'status' => $status,
            ]);

            if ($status == 'failed') {
                $shop = ShopModel::find($payment->shop_id);
                $shop->update([
                    'balance' => $shop->balance + $payment->amount,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update payment status');
        }

        return redirect()->back()->with('success', 'Payment status has been updated');
    }
}
