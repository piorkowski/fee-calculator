<?php

declare(strict_types=1);

namespace Interview\Infrastructure\Exception;

use Exception;
use Throwable;

class NonSupportedTermException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
