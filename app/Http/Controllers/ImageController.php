<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('PM_Image', 's3');

        return response()->json(['path' => $path], 200);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $path = $request->input('path');

        $deleted = Storage::disk('s3')->delete($path);
        if($deleted){
            return response()->json(['message' => 'Image has been deleted'], 200);
        }else{
            return response()->json(['message' => 'Image deleted fail'], 500);
        }
    }
}
