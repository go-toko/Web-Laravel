<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopModel extends Model
{
    use HasFactory;
    protected $table = 'shops';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->hasMany(ProductsModel::class, foreignKey:'shop_id');
    }

    public function paymentTransactions()
    {
        return $this->hasMany(MerchantPaymentTransactions::class, foreignKey:'shop_id');
    }

    public function paymentWithdrawals()
    {
        return $this->hasMany(MerchantPaymentWithdrawal::class, foreignKey:'shop_id');
    }
}
