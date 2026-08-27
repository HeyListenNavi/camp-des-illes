<?php

namespace App\Models;

use App\Enums\GroupEventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class GroupEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'guest_group_id',
        'start_date',
        'end_date',
        'expected_attendees',
        'status',
        'operational_notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => GroupEventStatus::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($event) {
            if (empty($event->token)) {
                $event->token = Str::random(32);
            }
        });
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(GuestGroup::class, 'guest_group_id');
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(EventServiceRequest::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
