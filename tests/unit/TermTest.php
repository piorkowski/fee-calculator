<?php

declare(strict_types=1);

namespace Interview\Tests\Unit;

use Interview\Domain\Exception\NoValidTermException;
use Interview\Domain\ValueObject\Term;
use PHPUnit\Framework\TestCase;

final class TermTest extends TestCase
{
    public function testAccepts12And24(): void
    {
        $t12 = new Term('12');
        $t24 = new Term('24');
        self::assertSame(12, $t12->value());
        self::assertSame(24, $t24->value());
    }

    public function testRejectsInvalidTerm(): void
    {
        $this->expectException(NoValidTermException::class);
        new Term('18');
    }
}
