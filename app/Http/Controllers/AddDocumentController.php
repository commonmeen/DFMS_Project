<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo ;
use App\Repositories\Eloquent\EloquentTemplateRepository as tempRepo ;

class AddDocumentController extends Controller
{
    public function addDoc(Request $request){
        if(Session::has('UserLogin')){
            $tempCanUse = tempRepo::listOnTemplate();
            return view("AddDocument",['template'=>$tempCanUse]);
        } else {
            return view('Login');
        }
    }
}
