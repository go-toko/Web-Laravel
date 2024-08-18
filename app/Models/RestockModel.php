<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockModel extends Model
{
    use HasFactory;
    protected $table = 'restock';
    protected $guarded = ['id'];

    public const status = ['PROSES', 'SIAP DITAMBAHKAN', 'SELESAI', 'BATAL'];

    public function detail()
    {
        return $this->hasMany(RestockDetailModel::class, foreignKey: 'restock_id');
    }
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class);
    }
    public function shop()
    {
        return $this->belongsTo(ShopModel::class);
    }
}
