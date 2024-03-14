<?php

namespace Database\Seeders;

use App\Models\rolesModel;
use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        rolesModel::create([
            'name' => 'Superadmin',
        ]);
        rolesModel::create([
            'name' => 'Owner',
        ]);
        rolesModel::create([
            'name' => 'Cashier',
        ]);
    }
}
