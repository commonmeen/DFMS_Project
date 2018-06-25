<?php

namespace App\Repositories\Eloquent;

use App\Models\Document;
use App\Repositories\Contracts\DocumentRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentDocumentRepository extends AbstractRepository implements DocumentRepository
{
    public function entity()
    {
        return Document::class;
    }

    public static function getDocumentById($id){
        $data = Document::where('document_Id',$id)->first();
        return json_decode($data,true);
    }

    public static function listDocumentByUserId($userId){
        $data = Document::where('document_Author',$userId)->get();
        return json_decode($data,true);
    }

    public static function filterDocumentByFlow($flow,$documentList){
        $documentCanUse = array();
        foreach($flow['template_Id'] as $template){
            foreach($documentList as $doc){
                if($template == $doc['document_TemplateId']){
                    array_push($documentCanUse,$doc);
                }
            }
        }
        return $documentCanUse ;
    }
}
