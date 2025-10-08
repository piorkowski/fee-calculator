<?php

declare(strict_types=1);

namespace Interview\Tests\Unit;

use Interview\Domain\Exception\NegativeAmountException;
use Interview\Domain\Exception\NoValidAmountException;
use Interview\Domain\Exception\TooHighAmountException;
use Interview\Domain\Exception\TooLowerAmountException;
use Interview\Domain\ValueObject\Amount;
use PHPUnit\Framework\TestCase;

final class AmountTest extends TestCase
{
    public function testParsesThousandsAndDecimals(): void
    {
        $a = new Amount('11,500.25');
        self::assertSame(1150025, $a->value());
        self::assertSame('11,500.25', (string) $a);
    }

    public function testRejectsNegative(): void
    {
        $this->expectException(NegativeAmountException::class);
        new Amount('-1');
    }

    public function testRangeBelowMin(): void
    {
        $this->expectException(TooLowerAmountException::class);
        new Amount('999.99');
    }

    public function testRangeAboveMax(): void
    {
        $this->expectException(TooHighAmountException::class);
        new Amount('20000.01');
    }

    public function testInvalidFormatTooManyDecimals(): void
    {
        $this->expectException(NoValidAmountException::class);
        new Amount('10.123');
    }
}
