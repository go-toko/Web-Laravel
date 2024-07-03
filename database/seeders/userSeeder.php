<?php

namespace Database\Seeders;

use App\Models\DumProductModel;
use App\Models\DumShopModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        $genders = ['male', 'female'];

        for ($i = 0; $i < 100; $i++) {

            try {
                DB::beginTransaction();
                $user = new User;
                $user->email = $faker->unique()->email();
                $user->password = bcrypt('password');
                $user->role_id = 2;
                $user->save();

                $profile = new UserProfileModel;
                $profile->user_id = $user->id;
                $profile->picture = $faker->imageUrl(360, 360, 'animals', true, 'cats');
                $profile->phone = $faker->phoneNumber();
                $profile->first_name = $faker->firstName();
                $profile->last_name = $faker->lastName();
                $profile->nickname = $faker->name();
                $profile->gender = $genders[array_rand($genders)];
                $profile->birthdate = $faker->date();
                $profile->address = $faker->address();
                $profile->save();

                for ($sh = 0; $sh < rand(0, 3); $sh++) {
                    $shop = new DumShopModel;
                    $shop->user_id = $user->id;
                    $shop->name = $faker->company();
                    $shop->address = $faker->address();
                    $shop->email = $faker->companyEmail();
                    $shop->contact_person = $faker->e164PhoneNumber();
                    $shop->description = $faker->sentence();
                    $shop->logo = $faker->imageUrl(360, 360);
                    $shop->status = true;
                    $shop->save();
                }

                for ($p = 0; $p < rand(0, 8); $p++) {
                    $product = new DumProductModel;
                    $product->category_id = rand(1, 10);
                    $product->brand_id = rand(1, 10);
                    $product->shop_id = $shop->id;
                    $product->name = $faker->word();
                    $product->sku = $faker->isbn13();
                    $product->price_buy = $faker->randomDigitNotZero() * 10000;
                    $product->price_sell = $faker->randomDigitNotZero() * 10000;
                    $product->quantity = $faker->randomNumber(3, false);
                    $product->save();
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
            }

        }
    }
}
