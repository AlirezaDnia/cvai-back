<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Actions\Resume\OptimizeResumeAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AIController extends Controller
{
    public function optimize(Request $request, Resume $resume, OptimizeResumeAction $optimizeAction): JsonResponse
    {
        $this->authorize('update', $resume);

        $validated = $request->validate([
            'target_job' => 'required|string|max:255',
        ]);

        $success = $optimizeAction($resume, $validated['target_job']);

        if (!$success) {
            return response()->json(['message' => 'AI optimization failed'], 500);
        }

        return response()->json([
            'message' => 'Resume optimized successfully by AI',
            'resume' => $resume->load('data')
        ]);
    }
}
