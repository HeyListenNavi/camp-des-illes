<?php

namespace App\Livewire\Public;

use App\Models\Document;
use App\Models\EventServiceRequest;
use App\Models\FormSubmission;
use App\Models\GroupEvent;
use App\Models\GuestGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads; // 1. Importar la trait de Livewire

class GroupEventRegistrationForm extends Component
{
    use WithFileUploads; // 2. Usar la trait

    // Guest Group fields
    public string $group_name = '';
    public ?string $organization_name = null;
    public string $primary_contact_name = '';
    public string $phone = '';
    public string $email = '';
    public ?string $address = null;

    // Group Event fields
    public string $start_date = '';
    public string $end_date = '';
    public int $expected_attendees = 20;
    public ?string $special_activities = null;

    // Document Uploads
    public $insurance_file = null;
    public $contract_file = null;

    // Dynamic Service Requests
    public array $services = [];

    public bool $submitted = false;
    public ?string $event_token = null;

    public function mount(): void
    {
        $this->services = [
            ['service_category' => 'lodging', 'service_name' => 'Hospedaje Cabañas', 'quantity' => 20, 'notes' => ''],
            ['service_category' => 'meal', 'service_name' => 'Servicio de Alimentación Completa', 'quantity' => 20, 'notes' => ''],
        ];
    }

    public function addService(): void
    {
        $this->services[] = [
            'service_category' => 'activity',
            'service_name' => '',
            'quantity' => 1,
            'notes' => '',
        ];
    }

    public function removeService(int $index): void
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    protected function rules(): array
    {
        return [
            'group_name' => 'required|string|max:255',
            'primary_contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'expected_attendees' => 'required|integer|min:1',
            'insurance_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Máx 10MB
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',      // Máx 10MB
            'services.*.service_category' => 'required|in:meal,lodging,activity',
            'services.*.service_name' => 'required|string|max:255',
            'services.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Crear o encontrar GuestGroup
            $group = GuestGroup::firstOrCreate(
                ['email' => trim($this->email)],
                [
                    'name' => trim($this->group_name),
                    'organization_name' => $this->organization_name ? trim($this->organization_name) : null,
                    'primary_contact_name' => trim($this->primary_contact_name),
                    'phone' => trim($this->phone),
                    'address' => $this->address,
                ]
            );

            // 2. Crear GroupEvent
            $event = GroupEvent::create([
                'guest_group_id' => $group->id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'expected_attendees' => $this->expected_attendees,
                'special_activities' => $this->special_activities,
                'status' => 'inquiry_received',
            ]);

            // 3. Subir y guardar Documentos polimórficos vinculados a GroupEvent
            if ($this->insurance_file) {
                $path = $this->insurance_file->store('documents/insurance', 'public');
                $event->documents()->create([
                    'title' => 'Póliza de Seguro',
                    'file_path' => $path,
                    'file_type' => $this->insurance_file->getClientOriginalExtension(),
                    'uploaded_at' => now(),
                ]);
            }

            if ($this->contract_file) {
                $path = $this->contract_file->store('documents/contracts', 'public');
                $event->documents()->create([
                    'title' => 'Contrato Firmado',
                    'file_path' => $path,
                    'file_type' => $this->contract_file->getClientOriginalExtension(),
                    'uploaded_at' => now(),
                ]);
            }

            // 4. Crear solicitudes de servicios asociados
            foreach ($this->services as $service) {
                if (!empty($service['service_name'])) {
                    EventServiceRequest::create([
                        'group_event_id' => $event->id,
                        'service_category' => $service['service_category'],
                        'service_name' => $service['service_name'],
                        'quantity' => $service['quantity'] ?? 1,
                        'notes' => $service['notes'] ?? null,
                    ]);
                }
            }

            // 5. Registro de Auditoría de Ingesta (FormSubmission)
            FormSubmission::create([
                'form_type' => 'registration',
                'processed_at' => now(),
                'ip_address' => request()->ip(),
                'payload' => [
                    'group' => [
                        'name' => $this->group_name,
                        'organization' => $this->organization_name,
                        'contact' => $this->primary_contact_name,
                        'email' => $this->email,
                    ],
                    'event' => [
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                        'attendees' => $this->expected_attendees,
                    ],
                    'documents_uploaded' => array_filter([
                        'insurance' => (bool) $this->insurance_file,
                        'contract' => (bool) $this->contract_file,
                    ]),
                    'services_count' => count($this->services),
                ],
            ]);

            $this->event_token = $event->token;
            $this->submitted = true;
        });
    }

    public function render()
    {
        return view('livewire.public.group-event-registration-form')
            ->layout('layouts.public', ['title' => 'Solicitud de Grupo']);
    }
}