<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPayment extends Model
{
    use HasFactory;

    public $table = "merchant_payment";

    protected $fillable = [
        'nama',
        'provider',
        'min_transaksi',
        'max_transaksi',
        'min_settlement',
        'max_settlement',
        'fee',
        'type_fee',
        'status'
    ];

    public function transactions()
    {
        return $this->hasMany(MerchantPaymentTransactions::class, 'payment_id');
    }
}
