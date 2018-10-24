<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo;

class DocumentDetailController extends Controller
{
    public function docDetail(Request $request){
        if(Session::has('UserLogin')){
            $input = $request->all();
            $thisDocument = docRepo::getDocumentById($input['doc_Id']);
            return view("DocumentDetail",['document'=>$thisDocument]);
        } else {
            return view('Login');
        }
    }
    
}
