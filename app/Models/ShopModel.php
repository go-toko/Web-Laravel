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
        return $this->hasMany(ProductsModel::class, foreignKey: 'shop_id');
    }

    public function userCashier()
    {
        return $this->hasOne(UserCashierModel::class, foreignKey: 'shop_id');
    }
    public function restock()
    {
        return $this->hasMany(RestockModel::class, foreignKey: 'restock_id');
    }
}
