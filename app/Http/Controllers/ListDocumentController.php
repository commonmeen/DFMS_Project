<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo;

class ListDocumentController extends Controller
{
    public function listDoc(){
        if(Session::has('UserLogin')){
            $documents = docRepo::listDocumentByUserId(Session::get('UserLogin')->user_Id);
            return view('ListDocument',['allDocument'=>$documents]);
        } else {
            return view('Login');
        }
    }
}
