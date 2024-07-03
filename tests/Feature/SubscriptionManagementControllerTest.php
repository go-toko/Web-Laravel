<?php
use App\Models\SubscriptionTypeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class SubscriptionManagementControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testStore()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Data subscription baru
        $subscriptionData = [
            'name' => 'Test Subscription',
            'description' => 'Test Description',
            'price' => 100,
            'time' => 7,
        ];

        // Memanggil route yang terkait dengan SubscriptionManagementController@store
        $response = $this->post(route('superadmin.subscription.management.store'), $subscriptionData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah subscription berhasil disimpan ke database
        $this->assertDatabaseHas('subscription_types', $subscriptionData);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success create the Subscription Type',
        ]);
    }

    public function testUpdate()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Menggunakan data subscription untuk pengujian
        $subscription = SubscriptionTypeModel::where('name', 'Test Subscription')->first();

        // Data update subscription
        $subscriptionUpdateData = [
            'name' => 'Updated Subscription',
            'description' => 'Updated Description',
            'price' => 200,
            'time' => 6,
        ];

        // Memanggil route yang terkait dengan SubscriptionManagementController@update
        $response = $this->post(route('superadmin.subscription.management.update', Crypt::encrypt($subscription->id)), $subscriptionUpdateData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah subscription berhasil diupdate di database
        $this->assertDatabaseHas('subscription_types', $subscriptionUpdateData);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success update the Subscription Type',
        ]);
    }

    public function testDestroy()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat data dummy subscription untuk pengujian
        $subscription = SubscriptionTypeModel::where('name', 'Updated Subscription')->first();

        // Memanggil route yang terkait dengan SubscriptionManagementController@destroy
        $response = $this->post(route('superadmin.subscription.management.destroy', Crypt::encrypt($subscription->id)));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi status sukses
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    public function testReportPdf()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@reportPdf
        $response = $this->get(route('superadmin.subscription.management.report-pdf'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function testReportExcel()
    {
        // Memanggil route yang terkait dengan ShopManagementController@reportExcel
        $response = $this->get(route('superadmin.subscription.management.report-excel'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file Excel
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    // public function tearDown():void{
    //     SubscriptionTypeModel::where('name', 'Updated Subscription')->delete();

    //     parent::tearDown();
    // }
}
