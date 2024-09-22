<?php

namespace App\Service;

use App\DTO\Request\Document\Item;
use App\Entity\Document;
use App\Entity\DocumentItem;
use App\Enum\Entity\DocumentType;
use App\Repository\DocumentItemRepository;

readonly class DocumentItemService
{
    public function __construct(
        private readonly DocumentItemRepository $repository,
        private readonly InventoryErrorService $inventoryErrorService,
    ) {
    }

    public function createDocumentItem(Item $item, Document $document): void
    {
        $documentItem = (new DocumentItem())
            ->setDocument($document)
            ->setProductId($item->productId)
            ->setQuantity($item->quantity)
            ->setUnitPrice(
                DocumentType::INCOMING->value === $document->getType()
                    ? $item->unitPrice
                    : null
            );

        $this->repository->save($documentItem);

        if (DocumentType::INVENTORY->value === $document->getType()) {
            $calculatedStock = $this->calculateStock($documentItem->getProductId());
            $this->inventoryErrorService->createInventoryError($documentItem, $calculatedStock);
        }
    }

    public function calculateStock(string $productId): int
    {
        $totalIncoming = $this->repository->getStockByType($productId, DocumentType::INCOMING->value);
        $totalOutgoing = $this->repository->getStockByType($productId, DocumentType::OUTGOING->value);

        return $totalIncoming - $totalOutgoing;
    }
}
