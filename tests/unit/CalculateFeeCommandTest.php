<?php

declare(strict_types=1);

namespace Interview\Tests\Unit;

use Interview\Infrastructure\Service\FeeServiceInterface;
use Interview\UI\CLI\Command\CalculateFeeCommand;
use Interview\UI\Parser\CliInputParser;
use Interview\UI\Validator\InputValidator;
use PHPUnit\Framework\TestCase;

final class CalculateFeeCommandTest extends TestCase
{
    public function testRunSuccess(): void
    {
        $fake = new class () implements FeeServiceInterface {
            public function calculate(\Interview\Infrastructure\DTO\CalculateFeeDTO $dto): int
            {
                return 46000;
            }
        };
        $cmd = new CalculateFeeCommand($fake, new CliInputParser(), new InputValidator());
        ob_start();
        $exit = $cmd->run(['php bin/calculate-fee', '11,500.25', '24']);
        $out = ob_get_clean();
        self::assertSame(0, $exit);
        self::assertSame("460.00\n", $out);
    }

    public function testRunUsageError(): void
    {
        $fake = new class () implements FeeServiceInterface {
            public function calculate(\Interview\Infrastructure\DTO\CalculateFeeDTO $dto): int
            {
                return 0;
            }
        };
        $cmd = new CalculateFeeCommand($fake, new CliInputParser(), new InputValidator());
        ob_start();
        $exit = $cmd->run(['php bin/calculate-fee', 'only-one-arg']);
        ob_get_clean();
        self::assertSame(1, $exit);
    }
}
