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

    public static function addNewDocument($name,$author,$template_Id,$data){
        $prev = Document::orderBy('document_Id','desc')->take(1)->get();
        $newId = 'D'.str_pad(substr($prev[0]->document_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $document = new Document ;
        $document->document_Id = $newId ;
        $document->document_Name = $name ;
        $document->document_Author = $author ;
        $document->document_TemplateId = $template_Id ;
        $document->data = $data ;
        $document->status = "unuse";
        $document->save();   
        return $newId;
    }
}
