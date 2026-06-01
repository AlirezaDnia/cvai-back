<?php

namespace App\Http\Controllers;

use App\Actions\Resume\OptimizeResumeAction;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AIController extends Controller
{
    public function optimize(Request $request, Resume $resume, OptimizeResumeAction $optimizeAction): JsonResponse
    {
        Gate::authorize('update', $resume);

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
