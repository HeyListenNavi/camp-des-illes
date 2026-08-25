<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class GuestGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'name',
        'organization_name',
        'primary_contact_name',
        'phone',
        'email',
        'address',
        'internal_notes',
        'access_token',
        'access_token_expires_at',
    ];

    protected $casts = [
        'access_token_expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($group) {
            if (empty($group->token)) {
                $group->token = Str::random(32);
            }
        });
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(GroupEvent::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
