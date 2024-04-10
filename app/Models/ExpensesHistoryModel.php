<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'expenses_history';
    protected $guarded = ['id'];
}
