<?php

namespace App\Exception;

use Exception;

class WrongTypeDocument extends Exception
{
    public function __construct(string $type, string $id)
    {
        parent::__construct("Неизвесный тип документа {$type} id: {$id}");
    }
}
