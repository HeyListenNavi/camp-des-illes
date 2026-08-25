<?php

namespace Tests\Feature;

use App\Livewire\Public\CamperRegistrationForm;
use App\Models\GroupEvent;
use App\Models\GuestGroup;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CampManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_auto_token_generation_on_models(): void
    {
        $group = GuestGroup::create([
            'name' => 'Grupo Exploradores',
            'primary_contact_name' => 'Ana López',
            'phone' => '555123456',
            'email' => 'ana@exploradores.org',
        ]);

        $this->assertNotEmpty($group->token);
        $this->assertEquals(32, strlen($group->token));

        $event = GroupEvent::create([
            'guest_group_id' => $group->id,
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-05',
            'expected_attendees' => 25,
            'status' => 'inquiry_received',
        ]);

        $this->assertNotEmpty($event->token);
        $this->assertEquals(32, strlen($event->token));
    }

    public function test_multi_camper_registration_and_deduplication(): void
    {
        // Register 2 campers at once under 1 guardian
        Livewire::test(CamperRegistrationForm::class)
            ->set('guardian_first_name', 'Carlos')
            ->set('guardian_last_name', 'García')
            ->set('guardian_phone', '555999888')
            ->set('guardian_email', 'carlos@example.com')
            ->set('relationship_type', 'father')
            ->set('session_year', '2026')
            ->set('campers', [
                [
                    'first_name' => 'Sofia',
                    'last_name' => 'García',
                    'gender' => 'female',
                    'date_of_birth' => '2015-05-20',
                    'allergies' => 'Nueces',
                    'medical_permission' => true,
                ],
                [
                    'first_name' => 'Lucas',
                    'last_name' => 'García',
                    'gender' => 'male',
                    'date_of_birth' => '2017-08-10',
                    'allergies' => 'Ninguna',
                    'medical_permission' => true,
                ],
            ])
            ->call('submit');

        $this->assertDatabaseHas('campers', [
            'first_name' => 'Sofia',
            'last_name' => 'García',
        ]);

        $this->assertDatabaseHas('campers', [
            'first_name' => 'Lucas',
            'last_name' => 'García',
        ]);

        $this->assertDatabaseCount('campers', 2);
        $this->assertDatabaseCount('camper_registrations', 2);

        // Next registration for Sofia next year under same guardian - Deduplicates Sofia's profile!
        Livewire::test(CamperRegistrationForm::class)
            ->set('guardian_first_name', 'Carlos')
            ->set('guardian_last_name', 'García')
            ->set('guardian_phone', '555999888')
            ->set('guardian_email', 'carlos@example.com')
            ->set('relationship_type', 'father')
            ->set('session_year', '2027')
            ->set('campers', [
                [
                    'first_name' => 'Sofia',
                    'last_name' => 'García',
                    'gender' => 'female',
                    'date_of_birth' => '2015-05-20',
                    'allergies' => 'Nueces',
                    'medical_permission' => true,
                ],
            ])
            ->call('submit');

        // Camper count remains 2 (Sofia + Lucas)
        $this->assertDatabaseCount('campers', 2);
        // Registrations count is 3 (Sofia 2026, Lucas 2026, Sofia 2027)
        $this->assertDatabaseCount('camper_registrations', 3);
    }
}
