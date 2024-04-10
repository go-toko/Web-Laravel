<?php

namespace Database\Seeders;

use App\Models\ProductsModel;
use App\Models\SalesDetailHistoryModel;
use App\Models\SalesDetailModel;
use App\Models\SalesHistoryModel;
use App\Models\SalesModel;
use App\Models\UserCashierModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class salesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id-ID');
        $cashierArray = UserCashierModel::where(['shop_id' => 1])->get()->toArray();
        $productsArray = ProductsModel::where(['shop_id' => 1])->get()->toArray();
        $paymentMethods = ['Cash', 'QRIS', 'Bank'];
        for ($i = 0; $i < 30; $i++) {
            try {
                DB::beginTransaction();
                $paidTotal = $faker->numberBetween(2, 20) * 10000;
                $sales = SalesModel::create([
                    'cashier_id' => $cashierArray[array_rand($cashierArray)]['user_id'],
                    'shop_id' => 1,
                    'date' => $faker->date(),
                    'customer_name' => $faker->name,
                    'total' => $paidTotal,
                    'paid' => $paidTotal,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                ]);

                $salesHistory = SalesHistoryModel::create([
                    'sales_id' => $sales->id,
                    'shop_id' => $sales->shop_id,
                    'date' => $sales->date,
                    'cashier_name' => $sales->cashier->userCashierProfile->name,
                    'customer_name' => $sales->customer_name,
                    'total' => $sales->total,
                    'paid' => $sales->paid,
                    'payment_method' => $sales->payment_method
                ]);
                for ($j = 0; $j < 3; $j++) {
                    $product = $productsArray[array_rand($productsArray)];
                    $quantity = $faker->numberBetween(1, 15);
                    $detail = SalesDetailModel::create([
                        'sales_id' => $sales->id,
                        'product_id' => $product['id'],
                        'buying_price' => $product['price_buy'],
                        'quantity' => $quantity,
                        'unit_price' => $product['price_sell'],
                        'total_price' => $product['price_sell'] * $quantity,
                    ]);
                    $detailHistory = SalesDetailHistoryModel::create([
                        'sales_history_id' => $salesHistory->id,
                        'product_name' => $detail->product->name,
                        'buying_price' => $detail->buying_price,
                        'quantity' => $detail->quantity,
                        'unit_price' => $detail->unit_price,
                        'total_price' => $detail->total_price
                    ]);
                }
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error($e);
                return;
            }
        }
    }
}
