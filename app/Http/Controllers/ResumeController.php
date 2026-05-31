<?php

namespace App\Http\Controllers;

use App\Actions\Resume\CreateResumeAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResumeController extends Controller
{
    public function store(Request $request, CreateResumeAction $createResumeAction): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'template_id' => 'nullable|string',
            'personal_info' => 'required|array',
            'personal_info.name' => 'required|string|max:255',
            'personal_info.email' => 'required|email',
        ]);

        $userId = $request->user()->id;

        $resume = $createResumeAction($validated, $userId);

        return response()->json([
            'message' => 'Resume draft created successfully',
            'resume' => $resume
        ], 201);
    }
}
