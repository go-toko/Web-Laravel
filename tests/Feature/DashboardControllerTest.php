<?php
use App\Models\ShopModel;
use App\Models\User;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();
        $this->actingAs($user);
        // Memanggil route yang terkait dengan DashboardController@index
        $response = $this->get(route('superadmin.dashboard'));

        // Memeriksa respons status code
        $response->assertStatus(200);
    }

    public function testGetUserCount()
    {
        // Menyiapkan data untuk pengujian
        $userCount = User::count();
        // Memanggil route yang terkait dengan DashboardController@getUserCount
        $response = $this->get(route('superadmin.getUserCount'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi count yang diharapkan
        $response->assertJson([
            'userCount' => $userCount,
        ]);
    }

    public function testGetUserOnlineCount()
    {
        $current_time = Carbon::now();
        $five_minutes_ago = $current_time->subMinutes(5);
        $userOnlineCount = User::where('last_seen', '>', $five_minutes_ago)->count();
        // Memanggil route yang terkait dengan DashboardController@getUserOnlineCount
        $response = $this->get(route('superadmin.getUserOnlineCount'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi count yang diharapkan
        $response->assertJson([
            'userOnlineCount' => $userOnlineCount,
        ]);
    }

    public function testGetSubscriberCount()
    {
        $current_time = Carbon::now();
        $subscriber = UserSubscriptionModel::where('expire', '>', $current_time)->count();

        // Memanggil route yang terkait dengan DashboardController@getSubscriberCount
        $response = $this->get(route('superadmin.getSubscriberCount'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi count yang diharapkan
        $response->assertJson([
            'subscriberCount' => $subscriber,
        ]);
    }

    public function testGetSubscriberChart()
    {
        // Memanggil route yang terkait dengan DashboardController@getSubscriberChart
        $response = $this->get(route('superadmin.getSubscriberChart'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi data yang diharapkan
        $response->assertJsonStructure([
            'labels',
            'data',
        ]);
    }

    public function testGetShopsCount()
    {
        $shops = ShopModel::count();
        // Memanggil route yang terkait dengan DashboardController@getShopsCount
        $response = $this->get(route('superadmin.getShopsCount'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi count yang diharapkan
        $response->assertJson([
            'shopsCount' => $shops,
        ]);
    }
}
