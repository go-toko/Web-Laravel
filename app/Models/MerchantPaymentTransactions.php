<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPaymentTransactions extends Model
{
    use HasFactory;

    public $table = 'merchant_payment_transactions';
    protected $fillable = [
        'payment_id',
        'shop_id',
        'sales_id',
        'transaction_ref',
        'payment_type',
        'amount',
        'payment_url',
        'description',
        'status',
        'expired_at',
        'payment_at',
    ];

    public function payment()
    {
        return $this->belongsTo(MerchantPayment::class, 'payment_id');
    }

    public function shop()
    {
        return $this->belongsTo(ShopModel::class, 'shop_id');
    }
}
