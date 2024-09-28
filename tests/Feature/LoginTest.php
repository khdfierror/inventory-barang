<?php

namespace Tests\Feature;

use App\Filament\Pages\Login;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::firstOrCreate([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@starter.com',
            'email_verified_at' => now(),
            'password' => bcrypt('filament-starter'),
        ]);

        Livewire::test(Login::class)
            ->fill([
                'username' => $user->username,
                'password' => 'filament-starter'
            ])
            ->call('authenticate')
            ->assertRedirect('/');
    }

}
