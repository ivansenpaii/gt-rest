<?php

namespace App\Service;

use App\DTO\Request\CreateDocument as CreateDocumentDto;

class DocumentService
{

    public function createDocument(CreateDocumentDto $request): string
    {
        return $documentId = '123';
    }
}