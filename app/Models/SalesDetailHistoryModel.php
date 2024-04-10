<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetailHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'sale_details_history';
    protected $guarded = ['id'];
}
