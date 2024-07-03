<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'products_category';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasMany(ProductsModel::class, 'category_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(ShopModel::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductsCategoryModel::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }
}
