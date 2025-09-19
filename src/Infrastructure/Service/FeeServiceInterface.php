<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Service;

use Lendable\Interview\Infrastructure\DTO\CalculateFeeDTO;

interface FeeServiceInterface
{
    public function calculate(CalculateFeeDTO $calculateFeeDTO): int;
}
