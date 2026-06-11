<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Niveau;
use App\Enums\Role;
use App\Models\User;
use App\Models\Specialite;
use App\Models\AnneeAcademique;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranscriptTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_transcript_displays_correct_labels_and_references(): void
    {
        // Arrange
        $annee = AnneeAcademique::factory()->create(['is_active' => true]);
        $specialite = Specialite::factory()->create();

        $student = User::factory()->create([
            'role' => Role::USER,
            'niveau' => Niveau::GCE_A_LEVEL,
            'specialite_id' => $specialite->id,
            'annee_academique_id' => $annee->id,
        ]);

        $admin = User::factory()->create(['role' => Role::ADMIN]);

        // Act
        $response = $this->actingAs($admin)->get(route('evaluations.releve-notes', $student));

        // Assert
        $response->assertStatus(200);

        // Check for updated titles and labels
        $response->assertSee("Relevé de notes en vue de l'obtention du Diplôme de Qualification Professionnelle(DQP)", false);
        $response->assertSee("NIVEAU SCOLAIRE");
        $response->assertSee("GCE ADVANCED A LEVEL");

        // Check for legal references
        $response->assertSee("Vu l'Arrêté n° 159/MINEFOP/SG/DFOP/SDGSF/SACD du 03 avril 2020 portant agrément", false);
        $response->assertSee("Vu l'Arrêté n° 00000226/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC du 06 mai 2022 portant renouvellement", false);
        $response->assertSee("Vu l'Arrêté n° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC du 10 juin 2025 portant renouvellement", false);

        // Check for QR Code presence
        $response->assertSee("data:image/png;base64,");
    }

    public function test_public_transcript_verification_is_accessible_without_authentication(): void
    {
        // Arrange
        $annee = AnneeAcademique::factory()->create(['is_active' => true]);
        $specialite = Specialite::factory()->create();

        $student = User::factory()->create([
            'role' => Role::USER,
            'niveau' => Niveau::GCE_A_LEVEL,
            'specialite_id' => $specialite->id,
            'annee_academique_id' => $annee->id,
        ]);

        $token = str_replace(['+', '/', '='], ['-', '_', ''], \Illuminate\Support\Facades\Crypt::encryptString((string) $student->id));

        // Act (without actingAs)
        $response = $this->get(route('evaluations.releve-notes.public', ['token' => $token]));

        // Assert
        $response->assertStatus(200);
        $response->assertSee("Document Officiel Vérifié");
        $response->assertSee("Relevé de notes en vue de l'obtention du Diplôme de Qualification Professionnelle(DQP)", false);
        $response->assertSee($student->name);
    }

    public function test_public_transcript_verification_returns_404_on_invalid_token(): void
    {
        // Act with invalid token
        $response = $this->get(route('evaluations.releve-notes.public', ['token' => 'invalid-token-here']));

        // Assert
        $response->assertStatus(404);
    }

    public function test_public_transcript_pdf_is_accessible_without_authentication(): void
    {
        // Arrange
        $annee = AnneeAcademique::factory()->create(['is_active' => true]);
        $specialite = Specialite::factory()->create();

        $student = User::factory()->create([
            'role' => Role::USER,
            'niveau' => Niveau::GCE_A_LEVEL,
            'specialite_id' => $specialite->id,
            'annee_academique_id' => $annee->id,
        ]);

        $token = str_replace(['+', '/', '='], ['-', '_', ''], \Illuminate\Support\Facades\Crypt::encryptString((string) $student->id));

        // Act (without actingAs)
        $response = $this->get(route('evaluations.releve-notes.public.pdf', ['token' => $token]));

        // Assert
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
