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
}
