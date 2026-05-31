<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeData extends Model
{
    protected $fillable = [
        'resume_id',
        'personal_info',
        'experience',
        'education',
        'skills',
        'projects',
        'languages'
    ];

    protected function casts(): array
    {
        return [
            'personal_info' => 'array',
            'experience' => 'array',
            'education' => 'array',
            'skills' => 'array',
            'projects' => 'array',
            'languages' => 'array',
        ];
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
