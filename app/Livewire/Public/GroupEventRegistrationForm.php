<?php 

namespace App\Livewire\Public;

use App\Models\Activity;
use App\Models\GroupEvent;
use App\Models\GuestGroup;
use App\Models\MealOption;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupEventRegistrationForm extends Component
{
    use WithFileUploads;

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

    // Quantities mapped by ID: [id => quantity]
    public array $selected_meals = [];
    public array $selected_rooms = [];
    public array $selected_activities = [];

    public bool $submitted = false;
    public ?string $event_token = null;

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
            'insurance_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'contract_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'selected_meals.*' => 'nullable|integer|min:0',
            'selected_rooms.*' => 'nullable|integer|min:0',
            'selected_activities.*' => 'nullable|integer|min:0',
        ];
    }

    public function mount(): void
    {
        $this->selected_meals = [];
        $this->selected_rooms = [];
        $this->selected_activities = [];
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

            // 3. Documentos
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

            // 4. Guardar solicitudes de servicio directamente en BD
            $servicesToInsert = [];

            // Meals
            $mealModels = MealOption::whereIn('id', array_keys($this->selected_meals))->get()->keyBy('id');
            foreach ($this->selected_meals as $id => $quantity) {
                if ((int)$quantity > 0 && isset($mealModels[$id])) {
                    $servicesToInsert[] = [
                        'service_category' => 'meal',
                        'service_name' => $mealModels[$id]->name,
                        'serviceable_id' => $id,
                        'serviceable_type' => MealOption::class,
                        'quantity' => (int)$quantity,
                    ];
                }
            }

            // Rooms
            $roomModels = RoomType::whereIn('id', array_keys($this->selected_rooms))->get()->keyBy('id');
            foreach ($this->selected_rooms as $id => $quantity) {
                if ((int)$quantity > 0 && isset($roomModels[$id])) {
                    $servicesToInsert[] = [
                        'service_category' => 'lodging',
                        'service_name' => $roomModels[$id]->name,
                        'serviceable_id' => $id,
                        'serviceable_type' => RoomType::class,
                        'quantity' => (int)$quantity,
                    ];
                }
            }

            // Activities
            $activityModels = Activity::whereIn('id', array_keys($this->selected_activities))->get()->keyBy('id');
            foreach ($this->selected_activities as $id => $quantity) {
                if ((int)$quantity > 0 && isset($activityModels[$id])) {
                    $servicesToInsert[] = [
                        'service_category' => 'activity',
                        'service_name' => $activityModels[$id]->name,
                        'serviceable_id' => $id,
                        'serviceable_type' => Activity::class,
                        'quantity' => (int)$quantity,
                    ];
                }
            }

            foreach ($servicesToInsert as $service) {
                $event->serviceRequests()->create($service);
            }

            $this->event_token = $event->token;
            $this->submitted = true;
        });
    }

    public function render()
    {
        return view('livewire.public.group-event-registration-form', [
            'mealOptions' => MealOption::where('is_active', true)->get(),
            'roomTypes'   => RoomType::where('is_active', true)->get(),
            'activities'  => Activity::where('is_active', true)->get(),
        ])->layout('layouts.public', ['title' => 'Solicitud de Grupo']);
    }
}