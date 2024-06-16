<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\MerchantPayment;
use App\Models\MerchantPaymentTransactions;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use App\Models\SalesModel;
use App\Models\ShopModel;
use Illuminate\Support\Facades\DB;

class PaydisiniController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetcher($body)
    {
        try {
            $response = $this->client->post('https://paydisini.co.id/api/', [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.5249.91 Safari/537.36',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => array_merge(
                    [
                        'key' => env('PAYDISINI_KEY'),
                        'note' => 'NewTransaction',
                    ],
                    $body,
                ),
            ]);

            $response = json_decode($response->getBody()->getContents());

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function randomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function callback(Request $request)
    {
        if ($request->signature === md5(env('PAYDISINI_KEY') . $request->unique_code . 'CallbackStatus')) {

            try {
                DB::beginTransaction();

                // Get transaction data
                $data = MerchantPaymentTransactions::where('transaction_ref', str($request->unique_code))->first();

                if (!$data) {
                    return response()->json([
                        'success' => false,
                    ]);
                }

                // Update transaction status
                $data->update([
                    'status' => $request->status === 'Success' ? 'success' : 'failed',
                    'payment_at' => $request->status === 'Success' ? now() : null,
                ]);

                $sales = SalesModel::where('id', $data->sales_id)->first();

                if ($request->status === 'Success') {
                    // Update sales status to paid
                    $sales->update([
                        'status' => 'PAID',
                    ]);

                    // Update shop balance
                    $shop = ShopModel::where('id', $data->shop_id)->first();
                    $shop->update([
                        'balance' => $shop->balance + $data->amount,
                    ]);
                } else {
                    // Update sales status to void
                    $sales->update([
                        'status' => 'VOID',
                    ]);
                }


                DB::commit();

                return response()->json([
                    'success' => true,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                ]);
            }
        }

        return response()->json([
            'success' => false,
        ]);
    }

    public function create(Request $request, $nama)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shop_id' => 'required',
                'sales_id' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]);
            }

            $data = MerchantPayment::where([
                'nama' => $nama,
                'provider' => 'Paydisini',
                'status' => 'ACTIVE',
            ])->first();

            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment not found or not active',
                ]);
            }

            $unique_code = $this->randomString(32);

            $response = $this->fetcher([
                'request' => 'new',
                'unique_code' => $unique_code,
                'service' => 11,
                'amount' => $request->amount,
                'valid_time' => 1800,
                'type_fee' => 1,
                'signature' => md5(env('PAYDISINI_KEY') . $unique_code . 11 . $request->amount . 1800 . 'NewTransaction'),
            ]);

            if (isset($response->success) && $response->success) {
                MerchantPaymentTransactions::create([
                    'payment_id' => $data->id,
                    'shop_id' => $request->shop_id,
                    'sales_id' => $request->sales_id,
                    'transaction_ref' => $unique_code,
                    'payment_type' => $nama,
                    'amount' => $response->data->amount,
                    'expired_at' => $response->data->expired,
                    'payment_url' => $response->data->checkout_url,
                    'description' => $response->data->qrcode_url,
                ]);
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
