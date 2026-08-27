<?php

namespace App\Models;

use App\Enums\DocumentFileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'title',
        'file_path',
        'file_type',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'file_type' => DocumentFileType::class,
            'uploaded_at' => 'datetime',
        ];
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}