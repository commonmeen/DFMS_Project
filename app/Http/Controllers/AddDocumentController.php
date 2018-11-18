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
            $alertStatus = "" ;
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
                        $data['name'] = $p->name ;
                        array_push($datas,$data) ;
                        break ;
                    }
                }
            }
            if(strpos($request->server('HTTP_REFERER'),"EditDocument")){
                $oldDocumentId = substr($request->server('HTTP_REFERER'), -6);
                $newDocumentId = docRepo::addNewDocument($input['name'],Session::get('UserLogin')->user_Id,$input['tempId'],$datas,$oldDocumentId);
                docRepo::changeStatus($oldDocumentId,$newDocumentId);
                $alertStatus = "EditSuccess";
            } else {
                $newDocumentId = docRepo::addNewDocument($input['name'],Session::get('UserLogin')->user_Id,$input['tempId'],$datas,"0");
                $alertStatus = "Success";
            }
            if(Session::has("NewProcess")){
                return redirect('DataProcess');
            } else {
                return redirect('DocumentDetail?doc_Id='.$newDocumentId)->with('alertStatus',$alertStatus);
            }
        } else {
            return view('Login');
        }
    }
}
