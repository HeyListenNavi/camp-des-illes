<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CamperMedical extends Model
{
    use HasFactory;

    protected $fillable = [
        'camper_id',
        'allergies',
        'medications',
        'dietary_restrictions',
        'critical_alerts',
    ];

    public function camper(): BelongsTo
    {
        return $this->belongsTo(Camper::class);
    }
}
