<?php

namespace App\Enum\Entity;

enum DocumentType: string
{
    case INCOMING = 'incoming';
    case OUTGOING = 'outgoing';
    case INVENTORY = 'inventory';
}
