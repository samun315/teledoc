<?php

namespace App\Http\Controllers;

use App\Services\Media\ImageOptimizer;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Handle both 'upload' (CKEditor format) and 'file' (Summernote format)
        $fileKey = $request->hasFile('upload') ? 'upload' : 'file';
        
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);

            // Validate file
            $request->validate([
                $fileKey => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $path = app(ImageOptimizer::class)->storeOnDisk($file, 'uploads');
            $filename = basename($path);

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
