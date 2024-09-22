<?php

namespace App\DTO\Response;

use DateTime;

class HistoryItem
{
    public function __construct(
        public string $documentId,
        public string $type,
        public int $quantity,
        public int $currentStock,
        public ?int $inventoryError = null,
        public string $createdAt,
    ) {
    }
}
