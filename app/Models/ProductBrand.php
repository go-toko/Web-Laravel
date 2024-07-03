<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;
    protected $table = 'products_brand';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasMany(ProductsModel::class, 'category_id', 'id');
    }
}
