<?php

declare(strict_types=1);

namespace Lendable\Interview\Domain\ValueObject;

final readonly class Fee
{
    /** Fee value in pence (minor units). */
    public function __construct(private int $value) {}

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        $pounds = intdiv($this->value, 100);
        $cents = $this->value % 100;
        return number_format($pounds, 0, '.', ',') . '.' . str_pad((string) $cents, 2, '0', STR_PAD_LEFT);
    }
}
