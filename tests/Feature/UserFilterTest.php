<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\AnneeAcademique;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_filtering(): void
    {
        // Arrange
        $specialite1 = Specialite::factory()->create();
        $specialite2 = Specialite::factory()->create();

        $annee1 = AnneeAcademique::factory()->create(['is_active' => true]);
        $annee2 = AnneeAcademique::factory()->create(['is_active' => false]);

        $userOfSpec1 = User::factory()->create([
            'role' => Role::USER,
            'specialite_id' => $specialite1->id,
            'annee_academique_id' => $annee1->id,
        ]);

        $userOfSpec2 = User::factory()->create([
            'role' => Role::USER,
            'specialite_id' => $specialite2->id,
            'annee_academique_id' => $annee2->id,
        ]);

        $admin = User::factory()->create(['role' => Role::ADMIN]);

        // Act & Assert - Filter by Spec 1
        $response = $this->actingAs($admin)->get(route('users.index', ['specialite_id' => $specialite1->id]));
        $response->assertStatus(200);
        $response->assertSee($userOfSpec1->name);
        $response->assertDontSee($userOfSpec2->name);

        // Act & Assert - Filter by Annee 2
        $response = $this->actingAs($admin)->get(route('users.index', ['annee_id' => $annee2->id]));
        $response->assertStatus(200);
        $response->assertDontSee($userOfSpec1->name);
        $response->assertSee($userOfSpec2->name);
    }
}
