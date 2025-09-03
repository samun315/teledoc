<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Validate file
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Store file in public/uploads directory
            $path = $file->storeAs('uploads', $filename, 'public');

            // Return CKEditor response format
            return response()->json([
                'url' => asset('storage/' . $path),
                'uploaded' => 1,
                'fileName' => $filename
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'No file uploaded'
            ]
        ]);
    }
}
