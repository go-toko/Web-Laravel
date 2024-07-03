<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionTypeModel extends Model
{
    use HasFactory;

    protected $table = 'subscription_types';

    protected $guarded = [
        'id'
    ];

    public function userSubscription()
    {
        return $this->hasMany(UserSubscriptionModel::class, foreignKey: 'subscription_types_id');
    }
}
