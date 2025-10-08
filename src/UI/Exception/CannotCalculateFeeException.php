<?php

declare(strict_types=1);

namespace Interview\UI\Exception;

use Exception;
use Throwable;

class CannotCalculateFeeException extends Exception
{
    public function __construct(int $code = 1, ?Throwable $previous = null)
    {
        parent::__construct('Cannot Calculate Fee', $code, $previous);
    }
}
