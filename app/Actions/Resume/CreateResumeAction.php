<?php

namespace App\Actions\Resume;

use App\Models\Resume;
use Illuminate\Support\Str;

class CreateResumeAction
{
    public function __invoke(array $data, int $userId): Resume
    {
        $slug = Str::slug($data['title']) . '-' . Str::random(5);

        $resume = Resume::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'slug' => $slug,
            'template_id' => $data['template_id'] ?? 'classic',
        ]);

        $resume->data()->create([
            'personal_info' => $data['personal_info'] ?? [],
            'experience' => [],
            'education' => [],
            'skills' => [],
            'projects' => [],
            'languages' => [],
        ]);

        return $resume->load('data');
    }
}
