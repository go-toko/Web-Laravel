<?php

namespace Database\Seeders;

use App\Models\SubscriptionTypeModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class subscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionTypeModel::create([
            'name' => 'Bronze',
            'description' => 'Subscribe for 1 month',
            'price' => 100000,
            'time' => 1,
            'isActive' => 1,
        ]);
        SubscriptionTypeModel::create([
            'name' => 'Silver',
            'description' => 'Subscribe for 3 month',
            'price' => 250000,
            'time' => 3,
            'isActive' => 1,
        ]);
        SubscriptionTypeModel::create([
            'name' => 'Gold',
            'description' => 'Subscribe for 6 month',
            'price' => 500000,
            'time' => 6,
            'isActive' => 1,
        ]);
    }
}
