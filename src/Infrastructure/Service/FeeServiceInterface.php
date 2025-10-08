<?php

declare(strict_types=1);

namespace Interview\Infrastructure\Service;

use Interview\Infrastructure\DTO\CalculateFeeDTO;

interface FeeServiceInterface
{
    public function calculate(CalculateFeeDTO $calculateFeeDTO): int;
}
