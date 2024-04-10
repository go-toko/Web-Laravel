<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCashierModel extends Model
{
    use HasFactory;

    protected $table = 'user_cashier';
    protected $guarded = [
        'id'
    ];

    public function shop()
    {
        return $this->belongsTo(ShopModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
