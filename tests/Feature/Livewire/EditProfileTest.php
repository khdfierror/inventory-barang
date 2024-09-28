<?php

namespace Tests\Feature\Livewire;

use App\Filament\Pages\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function edit_successfully()
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
            ->fill([
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '08123456789',
            ])
            ->call('submit')
            ->assertStatus(200);
    }
}
