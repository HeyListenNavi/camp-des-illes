<?php

namespace App\Livewire\Public;

use App\Models\CampEvent;
use App\Models\Camper;
use App\Models\CamperConsent;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use App\Models\Guardian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class CamperRegistrationForm extends Component
{
    public ?CampEvent $activeEvent = null;

    // Dynamic Guardians Array
    public array $guardians = [];

    // Dynamic Campers Array
    public array $campers = [];

    public bool $submitted = false;
    public array $registered_tokens = [];

    public function mount(): void
    {
        // Se obtiene automáticamente el campamento activo
        $this->activeEvent = CampEvent::where('is_active', true)->latest()->first();

        $this->addGuardian();
        $this->addCamper();
    }

    // ─── Guardian Methods ───────────────────────────────────────────────────────

    public function addGuardian(): void
    {
        $this->guardians[] = [
            'first_name'           => '',
            'last_name'            => '',
            'phone'                => '',
            'email'                => null,
            'address'              => null,
            'relationship_type'    => 'father',
            'is_primary_guardian'  => count($this->guardians) === 0,
            'is_emergency_contact' => true,
            'has_custody'          => false,
        ];
    }

    public function removeGuardian(int $index): void
    {
        if (count($this->guardians) > 1) {
            unset($this->guardians[$index]);
            $this->guardians = array_values($this->guardians);

            $hasPrimary = collect($this->guardians)->contains('is_primary_guardian', true);
            if (! $hasPrimary && isset($this->guardians[0])) {
                $this->guardians[0]['is_primary_guardian'] = true;
            }
        }
    }

    // ─── Camper Methods ─────────────────────────────────────────────────────────

    public function addCamper(): void
    {
        $this->campers[] = [
            'first_name'           => '',
            'last_name'            => '',
            'gender'               => 'male',
            'date_of_birth'        => '',
            'health_card_number'   => '',
            'address'              => '',
            'custody_details'      => '',
            'allergies'            => '',
            'medications'          => '',
            'dietary_restrictions' => '',
            'critical_alerts'      => '',
            'photo_permission'     => false,
            'travel_permission'    => false,
            'contact_permission'   => false,
            'medical_permission'   => false,
        ];
    }

    public function removeCamper(int $index): void
    {
        if (count($this->campers) > 1) {
            unset($this->campers[$index]);
            $this->campers = array_values($this->campers);
        }
    }

    // ─── Submit ─────────────────────────────────────────────────────────────────

    public function submit(): void
    {
        if (! $this->activeEvent) {
            session()->flash('error', 'No hay un evento de campamento activo configurado.');
            return;
        }

        $tokens = [];

        DB::transaction(function () use (&$tokens) {

            // 1. Crear o actualizar Tutores (Guardians)
            $guardianModels = [];
            foreach ($this->guardians as $gData) {
                if (! empty($gData['email'])) {
                    $guardian = Guardian::firstOrCreate(
                        ['email' => trim($gData['email'])],
                        [
                            'first_name'  => trim($gData['first_name']),
                            'last_name'   => trim($gData['last_name']),
                            'phone'       => trim($gData['phone']),
                            'address'     => $gData['address'] ?? null,
                            'has_custody' => (bool) ($gData['has_custody'] ?? false),
                        ]
                    );
                    $guardian->update([
                        'has_custody' => (bool) ($gData['has_custody'] ?? false),
                        'phone'       => trim($gData['phone']),
                    ]);
                } else {
                    $guardian = Guardian::create([
                        'first_name'  => trim($gData['first_name']),
                        'last_name'   => trim($gData['last_name']),
                        'phone'       => trim($gData['phone']),
                        'email'       => null,
                        'address'     => $gData['address'] ?? null,
                        'has_custody' => (bool) ($gData['has_custody'] ?? false),
                    ]);
                }

                $guardianModels[] = [
                    'model'                => $guardian,
                    'relationship_type'    => $gData['relationship_type'],
                    'is_primary_guardian'  => (bool) ($gData['is_primary_guardian'] ?? false),
                    'is_emergency_contact' => (bool) ($gData['is_emergency_contact'] ?? false),
                ];
            }

            // 2. Procesar acampantes (Campers)
            foreach ($this->campers as $item) {
                $dob = ! empty($item['date_of_birth']) 
                    ? \Carbon\Carbon::parse($item['date_of_birth'])->toDateString() 
                    : null;

                $camper = Camper::where('first_name', trim($item['first_name']))
                    ->where('last_name', trim($item['last_name']))
                    ->when($dob, fn ($query) => $query->whereDate('date_of_birth', $dob))
                    ->first();

                if (! $camper) {
                    $camper = Camper::create([
                        'first_name'         => trim($item['first_name']),
                        'last_name'          => trim($item['last_name']),
                        'date_of_birth'      => $dob,
                        'gender'             => $item['gender'] ?? 'male',
                        'address'            => $item['address'] ?? null,
                        'custody_details'    => $item['custody_details'] ?? null,
                        'health_card_number' => $item['health_card_number'] ?? null,
                    ]);
                }

                // 3. Vincular tutores con acampante
                foreach ($guardianModels as $gm) {
                    $camper->guardians()->syncWithoutDetaching([
                        $gm['model']->id => [
                            'relationship_type'    => $gm['relationship_type'],
                            'is_primary_guardian'  => $gm['is_primary_guardian'],
                            'is_emergency_contact' => $gm['is_emergency_contact'],
                        ],
                    ]);
                }

                // 4. Ficha Médica
                CamperMedical::updateOrCreate(
                    ['camper_id' => $camper->id],
                    [
                        'allergies'            => $item['allergies'] ?? null,
                        'medications'          => $item['medications'] ?? null,
                        'dietary_restrictions' => $item['dietary_restrictions'] ?? null,
                        'critical_alerts'      => $item['critical_alerts'] ?? null,
                    ]
                );

                // 5. REGISTRO OFICIAL DE INSCRIPCIÓN (Aquí se une el Camper con el CampEvent)
                $registration = CamperRegistration::firstOrCreate(
                    [
                        'camper_id'     => $camper->id,
                        'camp_event_id' => $this->activeEvent->id,
                    ],
                    [
                        'status' => 'pending',
                        'token'  => (string) Str::uuid(),
                    ]
                );

                // 6. Consentimientos
                CamperConsent::updateOrCreate(
                    ['camper_registration_id' => $registration->id],
                    [
                        'photo_permission'   => (bool) ($item['photo_permission'] ?? false),
                        'travel_permission'  => (bool) ($item['travel_permission'] ?? false),
                        'contact_permission' => (bool) ($item['contact_permission'] ?? false),
                        'medical_permission' => (bool) ($item['medical_permission'] ?? false),
                        'signed_at'          => now(),
                    ]
                );

                $tokens[] = [
                    'name'  => $item['first_name'] . ' ' . $item['last_name'],
                    'token' => $registration->token,
                ];
            }
        });

        $this->registered_tokens = $tokens;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.camper-registration-form', [
            'activeEvent' => $this->activeEvent,
        ])->layout('layouts.public', ['title' => 'Inscripción de Acampantes']);
    }
}