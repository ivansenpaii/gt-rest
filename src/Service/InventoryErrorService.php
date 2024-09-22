<?php

namespace App\Service;

use App\DTO\Response\HistoryItem;
use App\DTO\Response\InventoryItem;
use App\Entity\DocumentItem;
use App\Entity\InventoryError;
use App\Repository\DocumentItemRepository;
use App\Repository\InventoryErrorRepository;
use DateTime;
use DateTimeInterface;
use Exception;

readonly class InventoryErrorService
{
    public function __construct(
        private InventoryErrorRepository $repository,
        private ProductService $productService,
        private DocumentItemRepository $documentItemRepository,
    ) {
    }

    public function createInventoryError(DocumentItem $documentItem, int $currentStock): void
    {
        $calculateInventoryError = $documentItem->getQuantity() - $currentStock;

        $inventoryError = (new InventoryError())
            ->setDocumentItem($documentItem)
            ->setCalculatedStock($documentItem->getQuantity())
            ->setError($calculateInventoryError);

        $this->repository->save($inventoryError);
    }

    /**
     * @return InventoryItem[]
     * @throws Exception
     */
    public function inventoryByDate(string $startDate): array
    {
        $startDate = (new DateTime($startDate))->setTime(0, 0);

        $inventoryItems = $this->repository->inventoryByDate($startDate);

        $result = [];

        foreach ($inventoryItems as $inventoryItem) {
            $productId = $inventoryItem->getProductId();

            $calculatedStock = $this->calculateLastStock($productId);

            $errorInUnits = $inventoryItem->getQuantity() - $calculatedStock;

            $unitCost = $this->calculateWeightedAverageCost($productId, $startDate);

            $errorInRubles = $errorInUnits * $unitCost;

            $result[] = new InventoryItem(
                productId: $productId,
                inventoryQuantity: $inventoryItem->getQuantity(),
                calculatedStock: $calculatedStock,
                errorInUnits: $errorInUnits,
                errorInRubles: $errorInRubles
            );
        }

        return $result;
    }

    private function calculateWeightedAverageCost(string $productId, DateTimeInterface $date): float
    {
        $incomingItems = $this->documentItemRepository->findIncomingDocumentItemsByDate($productId, $date);

        if (empty($incomingItems)) {
            return $this->findLastIncomingCost($productId);
        }

        $totalQuantity = 0;
        $totalCost = 0;

        foreach ($incomingItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalCost += $item['quantity'] * $item['unitPrice'];
        }

        return $totalCost / $totalQuantity;
    }

    private function findLastIncomingCost(string $productId): float
    {
        $lastIncomingItem = $this->documentItemRepository->findLastIncomingItem($productId);

        return $lastIncomingItem['unitPrice'] ?? 0.0;
    }

    /**
     * @throws Exception
     */
    private function calculateLastStock($productId): int
    {
        $history = $this->productService->productHistory($productId);
        /** @var HistoryItem $lastStock */
        $lastStock = end($history);

        return $lastStock->quantity;
    }
}
