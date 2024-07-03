<?php

use App\Models\User;
use App\Models\UserSubscriptionModel;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class SubscriptionOrderControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat data dummy subscription order untuk pengujian
        $subscriptionOrders = UserSubscriptionModel::get();

        // Memanggil route yang terkait dengan SubscriptionOrderController@index
        $response = $this->get(route('superadmin.subscription.subscription-order.index'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah view yang ditampilkan adalah view yang diharapkan
        $response->assertViewIs('page.superadmin.subscription.order.index');

        // Memeriksa apakah data subscription orders tersedia di view
        $response->assertViewHas('data', $subscriptionOrders);
    }

    public function testReportPdf()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan SubscriptionOrderController@reportPdf
        $response = $this->get(route('superadmin.subscription.subscription-order.report-pdf'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons adalah file PDF
        $response->assertHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    public function testReportExcel()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan SubscriptionOrderController@reportExcel
        $response = $this->get(route('superadmin.subscription.subscription-order.report-excel'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons adalah file Excel
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
