<?php

namespace App\Controller\v1;

use App\Service\InventoryErrorService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryErrorController extends AbstractController
{
    public function __construct(private readonly InventoryErrorService $inventoryErrorService)
    {
    }

    /**
     * @throws Exception
     */
    #[Route(
        path: '/inventory/{date}',
        name: 'inventory_by_date',
        methods: [Request::METHOD_GET]
    )]
    public function inventoryByDate(string $date): JsonResponse
    {
        try {
            $inventory = $this->inventoryErrorService->inventoryByDate($date);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($inventory);
    }
}
