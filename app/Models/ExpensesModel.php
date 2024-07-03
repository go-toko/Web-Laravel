<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesModel extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(ExpensesCategoryModel::class);
    }
}
