<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request){
        $imageName = request()->file->getClientOriginalName();
        request()->file->move(public_path('upload'), $imageName);
        
        return response()->json(['uploaded' => '/upload/'.$imageName]);
    }
}
