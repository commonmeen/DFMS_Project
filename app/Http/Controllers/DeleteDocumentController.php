<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentDocumentRepository as documentRepo;
use Debugbar;
use Session;

class DeleteDocumentController extends Controller
{
    public function deleteDocument(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            Debugbar::info($input);
            $data = documentRepo::deleteDocumentById($input['document_Id']);
        } else {
            dd("Error occur", "Permission denied. Plz login on manager role.");
        }
    }
}
