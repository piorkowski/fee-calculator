<?php

declare(strict_types=1);

namespace Interview\UI\CLI\Command;

use Interview\Application\Service\FeeService;
use Interview\Infrastructure\DTO\CalculateFeeDTO;
use Interview\Infrastructure\Repository\InMemoryFeeRepository;
use Interview\Infrastructure\Service\FeeServiceInterface;
use Interview\UI\Exception\InvalidCliInputException;
use Interview\UI\Parser\CliInputParser;
use Interview\UI\Validator\InputValidator;

final readonly class CalculateFeeCommand
{
    public function __construct(
        private FeeServiceInterface $calculator,
        private CliInputParser                $parser,
        private InputValidator                $validator,
    ) {}

    public static function default(): self
    {
        return new self(
            new FeeService(new InMemoryFeeRepository()),
            new CliInputParser(),
            new InputValidator(),
        );
    }

    public function __invoke(string $amount, string $term): string
    {
        $pence  = $this->calculator->calculate(new CalculateFeeDTO($amount, $term));
        $pounds = intdiv($pence, 100);
        $cents  = $pence % 100;

        return number_format($pounds, 0, '.', ',') . '.' . str_pad((string) $cents, 2, '0', STR_PAD_LEFT);
    }

    /** @param array<int,string> $argv */
    public function run(array $argv): int
    {
        try {
            $input = $this->parser->parse($argv);
            $input = $this->validator->validate($input);

            $out = ($this)($input->amount, $input->term);
            fwrite(STDOUT, $out . PHP_EOL);
            return 0;

        } catch (InvalidCliInputException $exception) {
            fwrite(STDERR, $exception->getMessage() . PHP_EOL);
            return 1;

        } catch (\Throwable $exception) {
            fwrite(STDERR, $exception->getMessage() . PHP_EOL);
            return 1;
        }
    }
}
