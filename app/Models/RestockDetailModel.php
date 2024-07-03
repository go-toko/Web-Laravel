<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockDetailModel extends Model
{
    use HasFactory;
    protected $table = 'restock_detail';
    protected $guarded = ['id'];

    public function restock()
    {
        return $this->belongsTo(RestockModel::class);
    }
    public function product()
    {
        return $this->belongsTo(ProductsModel::class);
    }
}
