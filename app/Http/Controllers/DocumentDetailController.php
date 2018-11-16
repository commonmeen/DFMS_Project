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
            $previous = array();
            $thisDocument = docRepo::getDocumentById($input['doc_Id']);
            if($thisDocument['document_Author']==Session::get('UserLogin')->user_Id){
                if($thisDocument['previous_version'] != "0"){
                    $preDocument = docRepo::getDocumentById($thisDocument['previous_version']);
                    array_push($previous,$preDocument);
                    for( ; true ; ){
                        if($preDocument['previous_version']!="0"){
                            $preDocument = docRepo::getDocumentById($preDocument['previous_version']);
                            array_push($previous,$preDocument);
                        } else {
                            break ;
                        }
                    }
                }
                return view("DocumentDetail",['document'=>$thisDocument,'previous_ver'=>$previous]);
            } else {
                dd("Error Occur","Permission denide, You can't access this page.");
            }
        } else {
            return view('Login');
        }
    }
    
}
