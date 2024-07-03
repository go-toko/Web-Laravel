<?php

use App\Models\ShopModel;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class ShopManagementControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menggunakan data toko yang ada
        $shop = ShopModel::with('user')->get();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@index
        $response = $this->get(route('superadmin.people.shop.index'));

        // Memeriksa respons status code
        $response->assertStatus(200);
    }

    public function testShow()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menggunakan data toko yang ada
        $shop = ShopModel::with('user')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@show
        $response = $this->get(route('superadmin.people.shop.show', Crypt::encrypt($shop->id)));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah data toko yang diharapkan ditampilkan dalam view
        $response->assertViewHas('shop', function ($viewShop) use ($shop) {
            return $viewShop->id === $shop->id;
        });
    }

    public function testReportPdf()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@reportPdf
        $response = $this->get(route('superadmin.people.shop.report-pdf'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function testReportExcel()
    {
        // Memanggil route yang terkait dengan ShopManagementController@reportExcel
        $response = $this->get(route('superadmin.people.shop.report-excel'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file Excel
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function testReportDetailPdf()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menggunakan data toko yang ada
        $shop = ShopModel::with('user')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@reportDetailPdf
        $response = $this->get(route('superadmin.people.shop.report-detail-pdf', Crypt::encrypt($shop->id)));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }
}
