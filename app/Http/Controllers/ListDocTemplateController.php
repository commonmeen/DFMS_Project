<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;

class ListDocTemplateController extends Controller
{
    public function listTemplate(){
        $allTemplate = templateRepo::listTemplate();
        for($i = 0 ; $i < count($allTemplate) ; $i++ ){
            $allTemplate[$i]['template_AuthorName'] = userRepo::getUser($allTemplate[$i]['template_Author'])['user_Name'];
        }
        return view('ListDocTemplate',['allTemplate'=>$allTemplate]);
    }
}
