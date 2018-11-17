<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentDocumentRepository as documentRepo;
use Session;

class DeleteDocumentController extends Controller
{
    public function deleteDocument(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            $data = documentRepo::deleteDocumentById($input['document_Id']);
            Session::put('alertStatus','DeleteSuccess');
            return ;
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        }
    }
}
