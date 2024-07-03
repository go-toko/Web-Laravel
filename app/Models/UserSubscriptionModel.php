<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscriptionModel extends Model
{
    use HasFactory;

    protected $table = 'user_subscription';

    protected $guarded = [
        'id'
    ];

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionTypeModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
