<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use Storage ;

class FileUploadController extends Controller
{
    public function upload(Request $request){
        $files = request()->file ;
        $img = array();
        if($files!=null){
            foreach($files as $file){
                $imageName = $file->getClientOriginalName();
                for($i=1 ; Storage::disk('public')->exists('upload/'.$imageName) ; $i++){
                    $imageName = $file->getClientOriginalName();
                    $filename = pathinfo($imageName, PATHINFO_FILENAME);
                    $extension = pathinfo($imageName, PATHINFO_EXTENSION);
                    $imageName = $filename."(".$i.").".$extension;
                }
                $file->move(public_path('upload'), $imageName);   
                array_push($img,$imageName);
            }
            Session::put("fileUploaded",$img);
            return response()->json(['uploaded' => $img]) ;
        } else {
            return response()->json() ;
        }
    }
}
