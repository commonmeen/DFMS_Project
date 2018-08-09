<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;

class CheckTypeValidateController extends Controller
{
    public function chkValidate(Request $request){
        $input = $request->all();
        $step = stepRepo::getStepById($input['step_Id']);
        return ['type'=>$step['typeOfVerify']];
    }
}
