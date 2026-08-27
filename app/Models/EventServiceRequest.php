<?php

namespace App\Models;

use App\Enums\EventServiceCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_event_id',
        'service_category',
        'service_name',
        'quantity',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'service_category' => EventServiceCategory::class,
        ];
    }

    public function groupEvent(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class);
    }
}
