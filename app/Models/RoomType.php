<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'price_per_night',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    // Corregido: Es MorphMany porque EventServiceRequest usa 'serviceable'
    public function serviceRequests(): MorphMany
    {
        return $this->morphMany(EventServiceRequest::class, 'serviceable');
    }
}