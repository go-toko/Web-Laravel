<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesHistoryModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'sales_history';
}
