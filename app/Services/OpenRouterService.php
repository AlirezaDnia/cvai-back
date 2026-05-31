<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
        $this->baseUrl = 'https://openrouter.ai/api/v1/chat/completions';
        $this->model = config('services.openrouter.model', 'google/gemini-2.5-flash');
    }

    public function optimize(array $rawData, string $targetJob): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'cvai App',
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt($targetJob)
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode($rawData)
                    ]
                ],
                'response_format' => ['type' => 'json_object']
            ]);

            if ($response->successful()) {
                return json_decode($response->json('choices.0.message.content'), true);
            }

            Log::error('OpenRouter Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return null;
        }
    }

    protected function getSystemPrompt(string $targetJob): string
    {
        return "You are an ATS expert. Rewrite the user's raw experience/skills into a professional resume for a '{$targetJob}' role. " .
            "Return ONLY a valid JSON object matching this schema exactly: " .
            "{\"personal_info\": {\"summary\": \"...\"}, \"experience\": [{\"role\": \"...\", \"company\": \"...\", \"highlights\": [\"...\"]}], \"skills\": [\"...\"]}";
    }
}
