<?php

namespace App\Controller\v1;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class ProductController extends AbstractController
{
    public function __construct(private readonly ProductService $service)
    {
    }

    /**
     * @throws Exception
     */
    #[Route(
        path: '/product/{productId}/history',
        name: 'product_history',
        methods: [Request::METHOD_GET]
    )]
    public function productHistory(string $productId): JsonResponse
    {
        try {
            $history = $this->service->productHistory($productId);
        } catch (Exception $e) {
            return new JsonResponse("Ошибка при поиске истории {$e->getMessage()}", Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($history);
    }
}
