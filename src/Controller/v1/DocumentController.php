<?php

namespace App\Controller\v1;

use App\DTO\Request\CreateDocument;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    public function __construct(private readonly DocumentService $service)
    {
    }

    //todo написать свой ValueResolver для вывода кастомных ошибок как JsonResponse
    #[Route(
        path: '/document',
        name: 'post_document',
        methods: [Request::METHOD_POST]
    )]
    public function createDocument(#[MapRequestPayload] CreateDocument $request): JsonResponse
    {
        $documentId = $this->service->createDocument($request);
        return new JsonResponse(['documentId' => $documentId], Response::HTTP_CREATED);
    }
}
