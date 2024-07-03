<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'expenses_category';
    protected $guarded = ['id'];
}