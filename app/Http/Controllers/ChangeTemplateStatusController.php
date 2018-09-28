<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo;

class ChangeTemplateStatusController extends Controller
{
    public function changeStatusTemplate(Request $request){
        $input = $request->all();
        templateRepo::changeStatus($input['template_id'],$input['newStatus']);
        return ;
    }
}
