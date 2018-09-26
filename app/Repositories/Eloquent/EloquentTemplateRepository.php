<?php

namespace App\Repositories\Eloquent;

use App\Models\Template;
use App\Repositories\Contracts\TemplateRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTemplateRepository extends AbstractRepository implements TemplateRepository
{
    public function entity()
    {
        return Template::class;
    }

    public static function listTemplate(){
        $data = Template::all();
        return json_decode($data,true);
    }

    public static function getTemplateById($id){
        $data = Template::where('template_Id',$id)->first();
        return json_decode($data);
    }

    public static function addTemplate($title,$user_Id,$desc,$properties){
        $prev = Template::orderBy('template_Id','desc')->take(1)->get();
        $properties = json_decode($properties,true);
        $newId = 'T'.str_pad(substr($prev[0]->template_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $template = new Template ;
        $template->template_Id = $newId ;
        $template->template_Name = $title ;
        $template->template_Author = $user_Id ;
        $template->template_Description = $desc ;
        $template->template_Properties = $properties ;
        $template->status = "on";
        $template->save();
        return $template ;
    }
}
