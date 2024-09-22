<?php

namespace App\Service;

use App\DTO\Response\HistoryItem as HistoryItemDto;
use App\DTO\Response\ProductHistory;
use App\Entity\DocumentItem as DocumentItemEntity;
use App\Enum\Entity\DocumentType;
use App\Exception\WrongTypeDocument;
use App\Repository\DocumentItemRepository;
use Exception;

readonly class ProductService
{
    public function __construct(
        private readonly DocumentItemRepository $documentItemRepository,
    ) {
    }

    /**
     * @throws Exception
     * @return HistoryItemDto[]
     */
    public function productHistory(string $productId): array
    {
        $documentItems = $this->documentItemRepository->findProductHistory($productId);

        if (empty($documentItems)) {
            return [];
        }

        $history = [];
        $currentStock = 0;

        /** @var DocumentItemEntity $documentItem */
        foreach ($documentItems as $documentItem) {
            $document = $documentItem->getDocument();
            $quantity = $documentItem->getQuantity();

            switch ($document->getType()) {
                case DocumentType::INCOMING->value:
                    $currentStock += $quantity;
                    break;

                case DocumentType::OUTGOING->value:
                    $currentStock -= $quantity;
                    break;

                case DocumentType::INVENTORY->value:
                    $inventoryQuantity = $quantity;
                    $inventoryError = $inventoryQuantity - $currentStock;
                    $currentStock = $inventoryQuantity;
                    break;

                default:
                    throw new WrongTypeDocument($document->getType(), $document->getId());
            }


            $history[] = new HistoryItemDto(
                $document->getId(),
                $document->getType(),
                $quantity,
                $currentStock,
                $inventoryError ?? null,
                $document->getCreatedAt()->format('Y-m-d H:i:s'),
            );
        }

        return $history;
    }


}
