<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('pages.feedback.index');
    }

    public function show($feedback_id)
    {
        $feedback = Feedback::findOrFail($feedback_id);
        return view('pages.feedback.show', compact('feedback'));
    }

    public function updateStatus(Request $request, $feedback_id)
    {
        try {
            $feedback = Feedback::findOrFail($feedback_id);
            $feedback->status = $request->status;
            $feedback->admin_notes = $request->admin_notes ?? $feedback->admin_notes;
            $feedback->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'status' => $feedback->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDataTable(Request $request)
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();

        $data = $feedbacks->map(function ($feedback, $index) {
            return [
                'DT_RowIndex' => $index + 1,
                'feedback_id' => $feedback->feedback_id,
                'name' => $feedback->name,
                'phone' => $feedback->phone,
                'message' => \Str::limit($feedback->message, 100),
                'status' => $feedback->status,
                'created_at' => $feedback->created_at->format('d M, Y h:i A'),
                'action' => '<div class="d-flex gap-2">
                    <a href="' . route('feedback.show', $feedback->feedback_id) . '" class="btn btn-sm btn-light-primary" title="View Details">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>'
            ];
        });

        return response()->json(['data' => $data]);
    }
}
