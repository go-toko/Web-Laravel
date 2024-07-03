<?php

use App\Models\MenuModel;
use App\Models\RoleMenuModel;
use App\Models\RolesModel;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndex()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Memanggil route yang terkait dengan MenuController@index
        $response = $this->get(route('superadmin.settings.menu.index'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah data role yang diharapkan ditampilkan dalam view
        $response->assertViewHas('roles', function ($viewRoles) {
            return $viewRoles instanceof Illuminate\Database\Eloquent\Collection;
        });
    }

    public function testStore()
    {
        // Menggunakan user yang sudah ada
        $user = User::with('userProfile')->where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat data dummy menu untuk pengujian
        $menuData = [
            'role_id' => 1,
            'name' => 'Test Menu',
            'url' => 'superadmin/test-menu',
            'status' => 1,
            'icon' => 'test-icon',
        ];

        // Memanggil route yang terkait dengan MenuController@store
        $response = $this->post(route('superadmin.settings.menu.store'), $menuData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah menu berhasil disimpan ke database
        $this->assertDatabaseHas('menus', [
            'name' => $menuData['name'],
            'url' => $menuData['url'],
            'icon' => $menuData['icon'],
            'status' => $menuData['status'],
        ]);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success create the menu',
        ]);
    }

    public function testUpdate()
    {
        // Menggunakan user yang sudah ada
        $user = User::with('userProfile')->where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Menggunakan data menu untuk pengujian
        $menu = MenuModel::where('name', 'Test Menu')->first();

        // Data update menu
        $menuUpdateData = [
            'role_id' => 1,
            'name' => 'Updated Menu',
            'url' => 'Superadmin/updated-menu',
            'status' => 1,
            'icon' => 'updated-icon',
        ];

        // Memanggil route yang terkait dengan MenuController@update
        $response = $this->post(route('superadmin.settings.menu.update', $menu->id), $menuUpdateData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah menu berhasil diupdate di database
        $this->assertDatabaseHas('menus', [
            'name' => $menuUpdateData['name'],
            'url' => $menuUpdateData['url'],
            'icon' => $menuUpdateData['icon'],
            'status' => $menuUpdateData['status'],
        ]);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success update the menu',
        ]);
    }

    public function testUpdateOrder()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Menggunakan data  role dan menu untuk pengujian
        $menu1 = RoleMenuModel::where('menu_id', '1')->first();
        $menu2 = RoleMenuModel::where('menu_id', '2')->first();

        // Menetapkan order menu
        $order = [$menu2->id, $menu1->id];

        // Memanggil route yang terkait dengan MenuController@updateOrder
        $response = $this->post(route('superadmin.settings.menu.updateOrder'), ['order' => $order]);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah order menu telah diupdate di database
        $this->assertEquals(1, RoleMenuModel::find($menu2->id)->order);
        $this->assertEquals(2, RoleMenuModel::find($menu1->id)->order);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success sort menu, please reload to see the update',
        ]);
    }

    public function testDestroy()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat data dummy menu untuk pengujian
        $menu = MenuModel::where('name', 'Updated Menu')->first();

        // Memanggil route yang terkait dengan MenuController@destroy
        $response = $this->post(route('superadmin.settings.menu.destroy', $menu->id));

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

        // Memanggil route yang terkait dengan MenuController@reportPdf
        $response = $this->get(route('superadmin.settings.menu.report-pdf'));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons merupakan file PDF
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }
}
