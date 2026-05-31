<?php

namespace App\Actions\Resume;

use App\Models\Resume;
use App\Services\OpenRouterService;

class OptimizeResumeAction
{
    public function __construct(
        protected OpenRouterService $aiService
    ) {}

    public function __invoke(Resume $resume, string $targetJob): bool
    {
        $resume->load('data');

        $aiResult = $this->aiService->optimize($resume->data->toArray(), $targetJob);

        if (!$aiResult) {
            return false;
        }

        $resume->data()->update([
            'personal_info' => array_merge($resume->data->personal_info, $aiResult['personal_info'] ?? []),
            'experience' => $aiResult['experience'] ?? $resume->data->experience,
            'skills' => $aiResult['skills'] ?? $resume->data->skills,
        ]);

        $resume->update(['ai_optimized' => true]);

        return true;
    }
}
