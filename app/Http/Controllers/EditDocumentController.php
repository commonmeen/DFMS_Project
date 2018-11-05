<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo;
use App\Repositories\Eloquent\EloquentTemplateRepository as tempRepo;

class EditDocumentController extends Controller
{
    public function editDoc(request $request){
        if(Session::has('UserLogin')){
            $document = docRepo::getDocumentById($request->input('doc_Id'));
            $tempCanUse = array();
            $template = tempRepo::getTemplateById($document['document_TemplateId']);
            for($i=0; $i<count($template->template_Properties);$i++){
                if($template->template_Properties[$i]->type!= "header"){
                    foreach($document['data'] as $detail){
                        if($template->template_Properties[$i]->name == $detail['name']){
                            if($template->template_Properties[$i]->type == "checkbox-group"){
                                for($j=0;$j<count($template->template_Properties[$i]->values);$j++){
                                    $status = 0 ;
                                    foreach($detail['detail'] as $selected){
                                        if($selected == $template->template_Properties[$i]->values[$j]->value){
                                            $template->template_Properties[$i]->values[$j]->selected = true ;
                                            $status = 1;
                                            break ;
                                        }
                                    }
                                    if($status == 0){
                                        $template->template_Properties[$i]->values[$j]->selected = false ;
                                    }
                                }                             
                            }
                            $template->template_Properties[$i]->value = $detail['detail'];
                            break;
                        }
                    }
                }
            }
            array_push($tempCanUse,(array)$template);
            return view("AddDocument",['template'=>$tempCanUse,'documentData'=>$document]);
        } else {
            return view('Login');
        }
    }
}
