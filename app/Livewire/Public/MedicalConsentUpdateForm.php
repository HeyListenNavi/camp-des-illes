<?php

namespace App\Livewire\Public;

use App\Models\CamperConsent;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MedicalConsentUpdateForm extends Component
{
    public string $token;

    public ?CamperRegistration $registration = null;

    // Medical fields
    public ?string $allergies = null;

    public ?string $medications = null;

    public ?string $dietary_restrictions = null;

    public ?string $critical_alerts = null;

    // Consent fields
    public bool $photo_permission = false;

    public bool $travel_permission = false;

    public bool $contact_permission = false;

    public bool $medical_permission = false;

    public bool $saved = false;

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->registration = CamperRegistration::with(['camper.medical', 'consent'])
            ->where('token', $token)
            ->first();

        if (! $this->registration) {
            session()->flash('warning', 'Invalid or expired access link.');

            return;
        }

        $medical = $this->registration->camper?->medical;
        if ($medical) {
            $this->allergies = $medical->allergies;
            $this->medications = $medical->medications;
            $this->dietary_restrictions = $medical->dietary_restrictions;
            $this->critical_alerts = $medical->critical_alerts;
        }

        $consent = $this->registration->consent;
        if ($consent) {
            $this->photo_permission = (bool) $consent->photo_permission;
            $this->travel_permission = (bool) $consent->travel_permission;
            $this->contact_permission = (bool) $consent->contact_permission;
            $this->medical_permission = (bool) $consent->medical_permission;
        }
    }

    protected function rules(): array
    {
        return [
            'medical_permission' => 'accepted',
        ];
    }

    public function save(): void
    {
        if (! $this->registration) {
            session()->flash('error', 'Unable to save. Invalid registration session.');

            return;
        }

        $this->validate();

        DB::transaction(function () {
            // Update Medical Record
            CamperMedical::updateOrCreate(
                ['camper_id' => $this->registration->camper_id],
                [
                    'allergies' => $this->allergies,
                    'medications' => $this->medications,
                    'dietary_restrictions' => $this->dietary_restrictions,
                    'critical_alerts' => $this->critical_alerts,
                ]
            );

            // Update Consents
            CamperConsent::updateOrCreate(
                ['camper_registration_id' => $this->registration->id],
                [
                    'photo_permission' => $this->photo_permission,
                    'travel_permission' => $this->travel_permission,
                    'contact_permission' => $this->contact_permission,
                    'medical_permission' => $this->medical_permission,
                    'signed_at' => now(),
                ]
            );

            // Auditoría (Deshabilitado temporalmente hasta definir modelo FormSubmission)
            /*
            FormSubmission::create([
                'form_type' => 'medical',
                'camper_registration_id' => $this->registration->id,
                'processed_at' => now(),
                'ip_address' => request()->ip(),
                'payload' => [
                    'updated_medical' => true,
                    'updated_consent' => true,
                ],
            ]);
            */

            $this->saved = true;
        });
    }

    public function render()
    {
        return view('livewire.public.medical-consent-update-form')
            ->layout('layouts.public', ['title' => 'Ficha Médica y Autorizaciones']);
    }
}
