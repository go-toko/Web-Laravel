<?php
use App\Models\MenuModel;
use App\Models\SubMenuModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class SubmenuControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testStore()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Menggunakan data menu dan roleMenu untuk pengujian
        $menu = MenuModel::where('name', 'Dashboard')->first();

        // Data submenu baru
        $submenuData = [
            'menu_id' => $menu->id,
            'name' => 'Test Submenu',
        ];

        // Memanggil route yang terkait dengan SubmenuController@store
        $response = $this->post(route('superadmin.settings.menu.submenu.store'), $submenuData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah submenu berhasil disimpan ke database
        $this->assertDatabaseHas('sub_menus', $submenuData);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success create the menu',
        ]);
    }

    public function testUpdate()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Menggunakan data menu untuk pengujian
        $menu = MenuModel::where('name', 'Dashboard')->first();

        // Menggunakan data submenu untuk pengujian
        $submenu = SubMenuModel::where('name', 'Test Submenu')->first();

        // Data update submenu
        $submenuUpdateData = [
            'menu_id' => $menu->id,
            'name' => 'Updated Submenu',
        ];

        // Memanggil route yang terkait dengan SubmenuController@update
        $response = $this->post(route('superadmin.settings.menu.submenu.update', $submenu->id), $submenuUpdateData);

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah submenu berhasil diupdate di database
        $this->assertDatabaseHas('sub_menus', $submenuUpdateData);

        // Memeriksa apakah respons JSON berisi pesan sukses
        $response->assertJson([
            'status' => 1,
            'msg' => 'Success create the menu',
        ]);
    }

    public function testDestroy()
    {
        // Menggunakan user yang sudah ada
        $user = User::where('email', 'ahmadhasanali24@student.uns.ac.id')->first();

        // Menetapkan pengguna yang masuk sebagai pengguna saat ini
        $this->actingAs($user);

        // Membuat data dummy submenu untuk pengujian
        $submenu = SubMenuModel::where('name', 'Updated Submenu')->first();

        // Memanggil route yang terkait dengan SubmenuController@destroy
        $response = $this->post(route('superadmin.settings.menu.submenu.destroy', $submenu->id));

        // Memeriksa respons status code
        $response->assertStatus(200);

        // Memeriksa apakah respons JSON berisi status sukses
        $response->assertJson([
            'status' => 'success',
        ]);
    }
}
