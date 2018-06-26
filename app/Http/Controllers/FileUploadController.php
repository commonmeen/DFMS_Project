<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request){
        $files = request()->file ;
        if($files!=null){
            foreach($files as $file){
                $imageName = $file->getClientOriginalName();
                $file->move(public_path('upload'), $imageName);   
            }
            return response()->json(['uploaded' => '/upload/'.$imageName]) ;
        } else {
            return response()->json() ;
        }
    }
}
