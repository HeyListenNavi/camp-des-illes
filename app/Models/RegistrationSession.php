<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtiene el último campamento/sesión creado y activo.
     */
    public static function getLatestActive(): ?self
    {
        return static::where('is_active', true)
            ->latest()
            ->first();
    }

    public function campers(): BelongsToMany
    {
        return $this->belongsToMany(Camper::class, 'camper_registration_session')
            ->withTimestamps();
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'guardian_registration_session')
            ->withTimestamps();
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(CamperRegistration::class);
    }
}