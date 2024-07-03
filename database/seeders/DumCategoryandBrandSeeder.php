<?php

namespace Database\Seeders;

use App\Models\DumBrandModel;
use App\Models\DumCategoryModel;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DumCategoryandBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 10; $i++) { 
            try {
                DB::beginTransaction();
                $category = new DumCategoryModel;
                $category->name = $faker->word();
                $category->code = $faker->isbn13();
                $category->description = $faker->sentence();
                $category->images = $faker->imageUrl(360,360);
                $category->save();

                $brand = new DumBrandModel;
                $brand->name = $faker->word();
                $brand->description = $faker->sentence();
                $brand->images = $faker->imageUrl(360,360);
                $brand->save();
                
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();   
            }
        }
    }
}
