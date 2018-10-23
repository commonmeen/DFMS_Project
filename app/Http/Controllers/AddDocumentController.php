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
            $input =   $request->all();
            $prop = json_decode($input['prop']);
            $datas = array();
            $nameOfProp = array_keys($input);
            foreach($prop as $p){
                $data = array();
                foreach($nameOfProp as $name){
                    if($p->type != "header" && $p->name == $name){
                        $data['title'] = $p->label ;
                        $data['detail'] = $input[$p->name] ;
                        array_push($datas,$data) ;
                        break ;
                    }
                }
            }
            $newDocumentId = docRepo::addNewDocument($input['name'],Session::get('UserLogin')->user_Id,$input['tempId'],$datas);
            return redirect('DocumentDetail?doc_Id='.$newDocumentId);
        } else {
            return view('Login');
        }
    }
}
