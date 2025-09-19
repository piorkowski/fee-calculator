<?php

declare(strict_types=1);

namespace Lendable\Interview\UI\Exception;

use Exception;
use Throwable;

class InvalidCliInputException extends Exception
{
    public function __construct(string $message, int $code = 1, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
