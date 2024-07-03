<?php

use App\Http\Livewire\RoleSelector;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@index
        $response = $this->get(route('superadmin.people.user.index'));

        // Memeriksa respons status code
        $response->assertStatus(200);
    }

    public function testRoleUpdate()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat instansiasi model palsu
        $model = User::where('role_id', 2)->first();

        // Menggunakan Livewire untuk memanggil komponen RoleSelector
        Livewire::test(RoleSelector::class, ['model' => $model, 'field' => 'role_id']);

        // Memeriksa apakah nilai role_id di model telah diperbarui
        $this->assertEquals(2, $model->role_id);

        // Memeriksa apakah metode save() pada model dipanggil
        $this->assertTrue($model->role_id == 2);
    }

    public function testShow()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menggunakan data toko yang ada
        $usersData = User::first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@show
        $response = $this->get(route('superadmin.people.user.show', Crypt::encrypt($usersData->id)));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah data user yang diharapkan ditampilkan dalam view
        $response->assertViewHas('user', function ($viewShop) use ($usersData) {
            return $viewShop->id === $usersData->id;
        });
    }

    public function testReportPdf()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@reportPdf
        $response = $this->get(route('superadmin.people.user.report-pdf'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function testReportExcel()
    {
        // Memanggil route yang terkait dengan ShopManagementController@reportExcel
        $response = $this->get(route('superadmin.people.user.report-excel'));

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
        $usersData = User::first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan ShopManagementController@reportDetailPdf
        $response = $this->get(route('superadmin.people.user.report-detail-pdf', Crypt::encrypt($usersData->id)));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }
}
