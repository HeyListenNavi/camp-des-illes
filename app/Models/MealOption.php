<?php

namespace App\Models;

use App\Enums\MealType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MealOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'meal_type',
        'description',
        'price_per_person',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'meal_type' => MealType::class,
            'is_active' => 'boolean',
            'price_per_person' => 'decimal:2',
        ];
    }

    // Corregido: Es MorphMany porque EventServiceRequest usa 'serviceable'
    public function serviceRequests(): MorphMany
    {
        return $this->morphMany(EventServiceRequest::class, 'serviceable');
    }
}