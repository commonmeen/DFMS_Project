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
}
