<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CamperConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'camper_registration_id',
        'photo_permission',
        'travel_permission',
        'contact_permission',
        'medical_permission',
        'signed_at',
    ];

    protected $casts = [
        'photo_permission'   => 'boolean',
        'travel_permission'  => 'boolean',
        'contact_permission' => 'boolean',
        'medical_permission' => 'boolean',
        'signed_at'          => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(CamperRegistration::class, 'camper_registration_id');
    }
}