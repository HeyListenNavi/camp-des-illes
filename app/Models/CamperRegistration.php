<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class CamperRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'camper_id',
        'session_year',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function ($registration) {
            if (empty($registration->token)) {
                $registration->token = Str::random(32);
            }
        });
    }

    public function camper(): BelongsTo
    {
        return $this->belongsTo(Camper::class);
    }

    public function consent(): HasOne
    {
        return $this->hasOne(CamperConsent::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function formSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
}
