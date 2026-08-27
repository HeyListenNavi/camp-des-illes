<?php

namespace App\Livewire\Public;

use App\Models\CampEvent;
use App\Models\Camper;
use App\Models\CamperConsent;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use App\Models\Guardian;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class CamperRegistrationForm extends Component
{
    #[Url]
    public ?string $token = null;

    public bool $isEditing = false;

    public ?int $registration_id = null;

    public ?CampEvent $activeEvent = null;

    // Dynamic Guardians Array
    public array $guardians = [];

    // Dynamic Campers Array
    public array $campers = [];

    public bool $submitted = false;

    public array $registered_tokens = [];

    public function mount(?string $token = null): void
    {
        $targetToken = $token ?? $this->token ?? request()->query('token');

        if (! empty($targetToken)) {
            $registration = CamperRegistration::with(['camper.medical', 'camper.guardians', 'consent', 'campEvent'])
                ->where('token', $targetToken)
                ->first();

            if ($registration) {
                $this->token = $targetToken;
                $this->isEditing = true;
                $this->registration_id = $registration->id;
                $this->activeEvent = $registration->campEvent ?? CampEvent::where('is_active', true)->latest()->first();

                // Pre-fill guardians
                $guardians = $registration->camper?->guardians;
                if ($guardians && $guardians->count() > 0) {
                    foreach ($guardians as $index => $g) {
                        $pivot = $g->pivot;
                        $this->guardians[] = [
                            'first_name' => $g->first_name,
                            'last_name' => $g->last_name,
                            'phone' => $g->phone ?? '',
                            'email' => $g->email,
                            'address' => $g->address,
                            'relationship_type' => $pivot?->relationship_type ?? 'father',
                            'is_primary_guardian' => (bool) ($pivot?->is_primary_guardian ?? ($index === 0)),
                            'is_emergency_contact' => (bool) ($pivot?->is_emergency_contact ?? true),
                            'has_custody' => (bool) $g->has_custody,
                        ];
                    }
                } else {
                    $this->addGuardian();
                }

                // Pre-fill camper
                $camper = $registration->camper;
                $medical = $camper?->medical;
                $consent = $registration->consent;

                $dobString = '';
                if ($camper?->date_of_birth) {
                    $dobString = is_string($camper->date_of_birth)
                        ? $camper->date_of_birth
                        : $camper->date_of_birth->format('Y-m-d');
                }

                $genderVal = 'male';
                if ($camper?->gender) {
                    $genderVal = is_object($camper->gender) ? $camper->gender->value : (string) $camper->gender;
                }

                $this->campers[] = [
                    'first_name' => $camper->first_name ?? '',
                    'last_name' => $camper->last_name ?? '',
                    'gender' => $genderVal,
                    'date_of_birth' => $dobString,
                    'health_card_number' => $camper->health_card_number ?? '',
                    'address' => $camper->address ?? '',
                    'custody_details' => $camper->custody_details ?? '',
                    'allergies' => $medical->allergies ?? '',
                    'medications' => $medical->medications ?? '',
                    'dietary_restrictions' => $medical->dietary_restrictions ?? '',
                    'critical_alerts' => $medical->critical_alerts ?? '',
                    'photo_permission' => (bool) ($consent->photo_permission ?? false),
                    'travel_permission' => (bool) ($consent->travel_permission ?? false),
                    'contact_permission' => (bool) ($consent->contact_permission ?? false),
                    'medical_permission' => (bool) ($consent->medical_permission ?? false),
                ];

                return;
            }

            session()->flash('warning', 'Invalid or expired access link. You may complete a new registration below.');
        }

        // Default new registration setup
        $this->activeEvent = CampEvent::where('is_active', true)->latest()->first();
        $this->addGuardian();
        $this->addCamper();
    }

    // ─── Guardian Methods ───────────────────────────────────────────────────────

    public function addGuardian(): void
    {
        $this->guardians[] = [
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'email' => null,
            'address' => null,
            'relationship_type' => 'father',
            'is_primary_guardian' => count($this->guardians) === 0,
            'is_emergency_contact' => true,
            'has_custody' => false,
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
            'first_name' => '',
            'last_name' => '',
            'gender' => 'male',
            'date_of_birth' => '',
            'health_card_number' => '',
            'address' => '',
            'custody_details' => '',
            'allergies' => '',
            'medications' => '',
            'dietary_restrictions' => '',
            'critical_alerts' => '',
            'photo_permission' => false,
            'travel_permission' => false,
            'contact_permission' => false,
            'medical_permission' => false,
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
            session()->flash('error', 'No active camp event is currently configured.');

            return;
        }

        $tokens = [];

        DB::transaction(function () use (&$tokens) {

            // 1. Process Guardians
            $guardianModels = [];
            foreach ($this->guardians as $gData) {
                if (! empty($gData['email'])) {
                    $guardian = Guardian::firstOrCreate(
                        ['email' => trim($gData['email'])],
                        [
                            'first_name' => trim($gData['first_name']),
                            'last_name' => trim($gData['last_name']),
                            'phone' => trim($gData['phone']),
                            'address' => $gData['address'] ?? null,
                            'has_custody' => (bool) ($gData['has_custody'] ?? false),
                        ]
                    );
                    $guardian->update([
                        'first_name' => trim($gData['first_name']),
                        'last_name' => trim($gData['last_name']),
                        'has_custody' => (bool) ($gData['has_custody'] ?? false),
                        'phone' => trim($gData['phone']),
                        'address' => $gData['address'] ?? null,
                    ]);
                } else {
                    $guardian = Guardian::create([
                        'first_name' => trim($gData['first_name']),
                        'last_name' => trim($gData['last_name']),
                        'phone' => trim($gData['phone']),
                        'email' => null,
                        'address' => $gData['address'] ?? null,
                        'has_custody' => (bool) ($gData['has_custody'] ?? false),
                    ]);
                }

                $guardianModels[] = [
                    'model' => $guardian,
                    'relationship_type' => $gData['relationship_type'],
                    'is_primary_guardian' => (bool) ($gData['is_primary_guardian'] ?? false),
                    'is_emergency_contact' => (bool) ($gData['is_emergency_contact'] ?? false),
                ];
            }

            // 2. Process Campers
            foreach ($this->campers as $item) {
                $dob = ! empty($item['date_of_birth'])
                    ? \Carbon\Carbon::parse($item['date_of_birth'])->toDateString()
                    : null;

                if ($this->isEditing && $this->registration_id) {
                    $registration = CamperRegistration::find($this->registration_id);
                    $camper = $registration?->camper;

                    if ($camper) {
                        $camper->update([
                            'first_name' => trim($item['first_name']),
                            'last_name' => trim($item['last_name']),
                            'date_of_birth' => $dob,
                            'gender' => $item['gender'] ?? 'male',
                            'address' => $item['address'] ?? null,
                            'custody_details' => $item['custody_details'] ?? null,
                            'health_card_number' => $item['health_card_number'] ?? null,
                        ]);
                    }
                } else {
                    $camper = Camper::where('first_name', trim($item['first_name']))
                        ->where('last_name', trim($item['last_name']))
                        ->when($dob, fn ($query) => $query->whereDate('date_of_birth', $dob))
                        ->first();

                    if (! $camper) {
                        $camper = Camper::create([
                            'first_name' => trim($item['first_name']),
                            'last_name' => trim($item['last_name']),
                            'date_of_birth' => $dob,
                            'gender' => $item['gender'] ?? 'male',
                            'address' => $item['address'] ?? null,
                            'custody_details' => $item['custody_details'] ?? null,
                            'health_card_number' => $item['health_card_number'] ?? null,
                        ]);
                    }

                    $registration = CamperRegistration::firstOrCreate(
                        [
                            'camper_id' => $camper->id,
                            'camp_event_id' => $this->activeEvent->id,
                        ],
                        [
                            'status' => 'pending',
                        ]
                    );
                }

                // 3. Attach guardians
                foreach ($guardianModels as $gm) {
                    $camper->guardians()->syncWithoutDetaching([
                        $gm['model']->id => [
                            'relationship_type' => $gm['relationship_type'],
                            'is_primary_guardian' => $gm['is_primary_guardian'],
                            'is_emergency_contact' => $gm['is_emergency_contact'],
                        ],
                    ]);
                }

                // 4. Medical Record
                CamperMedical::updateOrCreate(
                    ['camper_id' => $camper->id],
                    [
                        'allergies' => $item['allergies'] ?? null,
                        'medications' => $item['medications'] ?? null,
                        'dietary_restrictions' => $item['dietary_restrictions'] ?? null,
                        'critical_alerts' => $item['critical_alerts'] ?? null,
                    ]
                );

                // 5. Consents
                if (isset($registration) && $registration) {
                    CamperConsent::updateOrCreate(
                        ['camper_registration_id' => $registration->id],
                        [
                            'photo_permission' => (bool) ($item['photo_permission'] ?? false),
                            'travel_permission' => (bool) ($item['travel_permission'] ?? false),
                            'contact_permission' => (bool) ($item['contact_permission'] ?? false),
                            'medical_permission' => (bool) ($item['medical_permission'] ?? false),
                            'signed_at' => now(),
                        ]
                    );

                    $tokens[] = [
                        'name' => $item['first_name'].' '.$item['last_name'],
                        'token' => $registration->token,
                    ];
                }
            }
        });

        $this->registered_tokens = $tokens;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.camper-registration-form', [
            'activeEvent' => $this->activeEvent,
        ])->layout('layouts.public', ['title' => $this->isEditing ? 'Update Registration' : 'Inscripción de Acampantes']);
    }
}
