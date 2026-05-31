<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    protected $fillable = ['user_id', 'title', 'slug', 'template_id', 'is_published', 'ai_optimized'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function data(): HasOne
    {
        return $this->hasOne(ResumeData::class);
    }
}
