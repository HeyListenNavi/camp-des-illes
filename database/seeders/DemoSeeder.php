<?php

namespace Database\Seeders;

use App\Models\Camper;
use App\Models\CamperConsent;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador Campamento',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        $guardian = Guardian::firstOrCreate(
            ['email' => 'carlos.garcia@example.com'],
            [
                'first_name' => 'Carlos',
                'last_name' => 'García',
                'phone' => '+52 55 1234 5678',
                'address' => 'Av. Insurgentes Sur 123, Coyoacán, CDMX',
            ]
        );

        $dob = '2015-05-20';
        $camper = Camper::where('first_name', 'Sofía')
            ->where('last_name', 'García')
            ->whereDate('date_of_birth', $dob)
            ->first();

        if (! $camper) {
            $camper = Camper::create([
                'first_name' => 'Sofía',
                'last_name' => 'García',
                'date_of_birth' => $dob,
                'gender' => 'female',
                'health_card_number' => 'NSS-987654321',
            ]);
        }

        $camper->guardians()->syncWithoutDetaching([
            $guardian->id => [
                'relationship_type' => 'father',
                'is_primary_guardian' => true,
                'is_emergency_contact' => true,
            ]
        ]);

        $reg = CamperRegistration::firstOrCreate(
            [
                'camper_id' => $camper->id,
                'session_year' => '2026',
            ],
            [
                'token' => 'demo-token-12345',
                'status' => 'confirmed',
            ]
        );

        CamperMedical::updateOrCreate(
            ['camper_id' => $camper->id],
            [
                'allergies' => 'Nueces, polen de primavera',
                'medications' => 'Antihistamínico 5mg por las mañanas',
                'dietary_restrictions' => 'Vegetariano',
                'critical_alerts' => 'Llevar inhalador en excursiones',
            ]
        );

        CamperConsent::updateOrCreate(
            ['camper_registration_id' => $reg->id],
            [
                'photo_permission' => true,
                'travel_permission' => true,
                'contact_permission' => true,
                'medical_permission' => true,
                'signed_at' => now(),
            ]
        );
    }
}
