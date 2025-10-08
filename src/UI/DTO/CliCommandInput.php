<?php

declare(strict_types=1);

namespace Interview\UI\DTO;

final readonly class CliCommandInput
{
    public function __construct(
        public string $amount,
        public string $term,
    ) {}
}
