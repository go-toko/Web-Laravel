<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $guarded = ['id'];

    public function cashier()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(SalesDetailModel::class, foreignKey: 'sales_id');
    }

    public function shop()
    {
        return $this->belongsTo(ShopModel::class);
    }
}
