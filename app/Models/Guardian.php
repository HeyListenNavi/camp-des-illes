<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'has_custody',
        'access_token',
        'access_token_expires_at',
    ];

    protected $casts = [
        'has_custody' => 'boolean',
        'access_token_expires_at' => 'datetime',
    ];

    public function registrationSessions(): BelongsToMany
    {
        return $this->belongsToMany(RegistrationSession::class, 'guardian_registration_session')
            ->withTimestamps();
    }

    public function campers(): BelongsToMany
    {
        return $this->belongsToMany(Camper::class, 'camper_guardian')
            ->withPivot('relationship_type', 'is_primary_guardian', 'is_emergency_contact')
            ->withTimestamps();
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
