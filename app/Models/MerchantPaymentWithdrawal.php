<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPaymentWithdrawal extends Model
{
    use HasFactory;

    protected $table = 'merchant_payment_withdrawal';
    protected $fillable = ['bank', 'account_number', 'account_name', 'shop_id', 'amount', 'status', 'note'];

    public function shop()
    {
        return $this->belongsTo(ShopModel::class, 'shop_id');
    }
}
