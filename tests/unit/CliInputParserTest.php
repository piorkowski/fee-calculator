<?php

declare(strict_types=1);

namespace Interview\Tests\Unit;

use Interview\UI\Exception\InvalidCliInputException;
use Interview\UI\Parser\CliInputParser;
use PHPUnit\Framework\TestCase;

final class CliInputParserTest extends TestCase
{
    public function testParsesPositional(): void
    {
        $parser = new CliInputParser();
        $input = $parser->parse(['php bin/calculate-fee', '11500.25', '24']);
        self::assertSame('11500.25', $input->amount);
        self::assertSame('24', $input->term);
    }

    public function testParsesLongOptions(): void
    {
        $parser = new CliInputParser();
        $input = $parser->parse(['php bin/calculate-fee', '--amount=11500', '--term=12']);
        self::assertSame('11500', $input->amount);
        self::assertSame('12', $input->term);
    }

    public function testMissingArguments(): void
    {
        $this->expectException(InvalidCliInputException::class);
        (new CliInputParser())->parse(['script.php', '--amount=11500']);
    }
}
