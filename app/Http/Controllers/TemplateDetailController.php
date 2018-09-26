<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;

class TemplateDetailController extends Controller
{
    public function templateDetail(Request $request){
        $input = $request->all();
        $thisTemplate = templateRepo::getTemplateById($input['temp_id']);
        $authorObject = userRepo::getUser($thisTemplate->template_Author) ;
        $thisTemplate->template_AuthorName = $authorObject['user_Name'].' '.$authorObject['user_Surname'];
        return view('TemplateDetail',['template'=>$thisTemplate]);
    }
}
