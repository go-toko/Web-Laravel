<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testHandleGoogleCallback()
    {
        // Persiapan data user dari Socialite
        $userData = [
            'id' => '12345',
            'email' => 'test@example.com',
            'user' => [
                'picture' => 'http://example.com/profile.png',
                'given_name' => 'John',
                'family_name' => 'Doe',
            ],
            'nickname' => 'johndoe',
        ];

        // Memasang mock untuk Socialite dan mengatur pengembalian data user
        Socialite::shouldReceive('driver->user')->andReturn((object) $userData);

        // Memanggil route dengan route name 'google.callback'
        $response = $this->get(route('login.google.callback'));

        // Memeriksa respons status code
        $response->assertStatus(302);

        // Memeriksa apakah user baru berhasil disimpan dalam database
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'google_id' => $userData['id'],
            'role_id' => 2,
        ]);

        // Memeriksa apakah profile user baru berhasil disimpan dalam database
        $this->assertDatabaseHas('user_profile', [
            'picture' => $userData['user']['picture'],
            'first_name' => $userData['user']['given_name'],
            'last_name' => $userData['user']['family_name'],
            'nickname' => $userData['nickname'],
        ]);

        // Memeriksa apakah user baru berhasil login
        $this->assertTrue(Auth::check());

        // Memeriksa redirect sesuai dengan role user
        $response->assertRedirect(route('owner.complete-profile.index'));
    }

    public function tearDown(): void
    {
        // Menghapus data spesifik setelah pengujian selesai
        User::where('email', 'test@example.com')->delete();

        parent::tearDown();
    }
}
