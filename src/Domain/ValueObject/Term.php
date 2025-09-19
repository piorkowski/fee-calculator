<?php

declare(strict_types=1);

namespace Lendable\Interview\Domain\ValueObject;

use Lendable\Interview\Domain\Exception\NoValidTermException;

final readonly class Term
{
    private const array ALLOWED_TERMS = [12, 24];

    public function __construct(private string $term)
    {
        $this->validate($term);
    }

    public function value(): int
    {
        return (int) $this->term;
    }

    private function validate(string $term): void
    {
        $termInt = (int) $term;
        if (!in_array($termInt, self::ALLOWED_TERMS, true)) {
            throw new NoValidTermException('Invalid term: must be 12 or 24 months');
        }
    }
}
