<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'url',
        'icon',
        'status'
    ];

    public function roleMenu()
    {
        return $this->hasMany(RoleMenuModel::class, foreignKey: 'menu_id');
    }

    public function subMenu()
    {
        return $this->hasMany(SubMenuModel::class, foreignKey: 'menu_id');
    }
}
