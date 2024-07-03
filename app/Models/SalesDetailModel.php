<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetailModel extends Model
{
    use HasFactory;
    protected $table = 'sales_details';
    protected $guarded = ['id'];

    public function sales()
    {
        return $this->belongsTo(SalesModel::class);
    }

    public function product()
    {
        return $this->belongsTo(ProductsModel::class);
    }
}
