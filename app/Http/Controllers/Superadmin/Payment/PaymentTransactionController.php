<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use App\Models\MerchantPaymentTransactions;
use App\Models\ShopModel;

class PaymentTransactionController extends Controller
{
    public function index()
    {
        $data = ShopModel::with('user.userProfile')->get();
        return view('page.superadmin.payment.transaction.index', compact('data'));
    }

    public function detail($id)
    {
        $data = MerchantPaymentTransactions::with('payment')->where('shop_id', $id)->get();
        $groupByStatus = $data->groupBy('status')->map(function ($item) {
            return $item->sum('amount');
        });

        return view('page.superadmin.payment.transaction.detail', compact('data', 'groupByStatus'));
    }
}
