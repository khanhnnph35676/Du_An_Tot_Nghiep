<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            $url = asset('storage/' . $filePath);

            return response()->json([
                'uploaded' => true,
                'url' => $url,
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Upload failed',
            ],
        ]);
    }
}
