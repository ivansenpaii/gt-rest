<?php

namespace App\Controller\v1;

use App\DTO\Request\Document\CreateDocument;
use App\Service\DocumentService;
use Doctrine\DBAL\Exception;
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

    #[Route(
        path: '/document',
        name: 'create_document',
        methods: [Request::METHOD_POST]
    )]
    public function createDocument(#[MapRequestPayload] CreateDocument $request): JsonResponse
    {
        try {
            $id = $this->service->createDocument($request);
        } catch (Exception $e) {
            return new JsonResponse("Ошибка создания документа: {$e->getMessage()}", Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['documentId' => $id], Response::HTTP_CREATED);
    }
}
