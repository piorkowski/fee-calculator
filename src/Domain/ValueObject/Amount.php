<?php

declare(strict_types=1);

namespace Interview\Domain\ValueObject;

use Interview\Domain\Exception\NegativeAmountException;
use Interview\Domain\Exception\NoValidAmountException;
use Interview\Domain\Exception\TooHighAmountException;
use Interview\Domain\Exception\TooLowerAmountException;

final readonly class Amount
{
    private const int MIN_AMOUNT_POUNDS = 1000;
    private const int MAX_AMOUNT_POUNDS = 20000;
    private int $pence;

    public function __construct(private string $raw)
    {
        $this->pence = self::parseToPence($this->raw);
        $this->validateRange($this->pence);
    }

    public function value(): int
    {
        return $this->pence;
    }

    public function __toString(): string
    {
        $pounds = intdiv($this->pence, 100);
        $cents = $this->pence % 100;
        return number_format($pounds, 0, '.', ',') . '.' . str_pad((string) $cents, 2, '0', STR_PAD_LEFT);
    }

    private static function parseToPence(string $value): int
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new NoValidAmountException('Amount cannot be empty');
        }

        $normalized = str_replace([' ', ','], ['', ''], $trimmed);

        if (!preg_match('/^-?\d+(?:\.\d{1,2})?$/', $normalized)) {
            throw new NoValidAmountException('Invalid amount format');
        }

        $negative = $normalized[0] === '-';
        if ($negative) {
            throw new NegativeAmountException('Amount cannot be negative');
        }

        $parts = explode('.', $normalized, 2);
        $pounds = ltrim($parts[0], '+');
        $pence = 0;

        if (isset($parts[1])) {
            $frac = $parts[1];

            if (strlen($frac) === 1) {
                $frac .= '0';
            } elseif (strlen($frac) > 2) {
                throw new NoValidAmountException('Too many decimal places');
            }
            $pence = (int) $frac;
        }

        return ((int) $pounds) * 100 + $pence;
    }

    private function validateRange(int $pence): void
    {
        $min = self::MIN_AMOUNT_POUNDS * 100;
        $max = self::MAX_AMOUNT_POUNDS * 100;

        if ($pence < $min) {
            throw new TooLowerAmountException('Amount below minimum of ' . self::MIN_AMOUNT_POUNDS);
        }
        if ($pence > $max) {
            throw new TooHighAmountException('Amount above maximum of ' . self::MAX_AMOUNT_POUNDS);
        }
    }
}
