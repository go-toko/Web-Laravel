<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenuModel extends Model
{
    use HasFactory;

    protected $table = 'roles_menus';

    protected $guarded = [
        'id',
    ];

    public function role()
    {
        return $this->belongsTo(RolesModel::class);
    }

    public function menu()
    {
        return $this->belongsTo(MenuModel::class);
    }
}
