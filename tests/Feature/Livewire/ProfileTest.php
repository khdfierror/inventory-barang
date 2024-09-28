<?php

namespace Tests\Feature\Livewire;

use App\Filament\Pages\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function renders_successfully()
    {
        $user = User::firstOrCreate([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@starter.com',
            'email_verified_at' => now(),
            'password' => bcrypt('filament-starter'),
        ]);
        Livewire::actingAs($user)
            ->test(Profile::class)
            ->assertStatus(200);
    }
}
