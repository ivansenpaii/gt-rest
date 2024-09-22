<?php

namespace App\DTO\Response;

class InventoryItem
{
    public function __construct(
        public string $productId,
        public int $inventoryQuantity,
        public int $calculatedStock,
        public int $errorInUnits,
        public float $errorInRubles,
    ) {
    }
}
