<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Camper extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'address',
        'custody_details',
        'health_card_number',
        'access_token',
        'access_token_expires_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'access_token_expires_at' => 'datetime',
    ];

    public function registrationSessions(): BelongsToMany
    {
        return $this->belongsToMany(RegistrationSession::class, 'camper_registration_session')
            ->withTimestamps();
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'camper_guardian')
            ->withPivot('relationship_type', 'is_primary_guardian', 'is_emergency_contact')
            ->withTimestamps();
    }

    public function medical(): HasOne
    {
        return $this->hasOne(CamperMedical::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(CamperRegistration::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}