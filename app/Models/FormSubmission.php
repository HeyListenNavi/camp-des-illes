<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'form_type',
        'camper_registration_id',
        'processed_at',
        'ip_address',
        'payload',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'payload' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($submission) {
            if (empty($submission->token)) {
                $submission->token = Str::random(32);
            }
        });
    }

    public function camperRegistration(): BelongsTo
    {
        return $this->belongsTo(CamperRegistration::class);
    }
}
