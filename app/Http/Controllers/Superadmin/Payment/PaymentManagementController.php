<?php

namespace App\Http\Controllers\Superadmin\Payment;

use App\Http\Controllers\Controller;
use App\Models\MerchantPayment;

class PaymentManagementController extends Controller
{
    public function index()
    {
        $data = MerchantPayment::all();

        return view('page.superadmin.payment.management.index', compact('data'));
    }

    public function edit($id, $status)
    {
        MerchantPayment::find($id)->update([
            'status' => $status
        ]);
        
        return redirect()->back()->with('success', 'Payment status has been updated');
    }
}
