<?php

declare(strict_types=1);

namespace Interview\Infrastructure\DTO;

final readonly class CalculateFeeDTO
{
    public function __construct(
        public string $amount,
        public string $term,
    ) {}
}
