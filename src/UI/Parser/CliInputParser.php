<?php

declare(strict_types=1);

namespace Interview\UI\Parser;

use Interview\UI\DTO\CliCommandInput;
use Interview\UI\Exception\InvalidCliInputException;

final class CliInputParser
{
    /**
     * @param array<int,string> $argv
     * @throws InvalidCliInputException
     */
    public function parse(array $argv): CliCommandInput
    {
        $args = $argv;
        array_shift($args);

        $amount = null;
        $term   = null;

        foreach ($args as $arg) {
            if (str_starts_with($arg, '--amount=')) {
                $amount = substr($arg, 9);
                continue;
            }
            if (str_starts_with($arg, '--term=')) {
                $term = substr($arg, 7);
            }
        }

        if ($amount === null || $term === null) {
            if (count($args) >= 2) {
                $amount ??= $args[0];
                $term   ??= $args[1];
            }
        }

        if ($amount === null || $term === null) {
            throw new InvalidCliInputException(
                "Usage: php bin/calculate-fee <amount> <term>\n"
                . '   or: php bin/calculate-fee --amount=<amount> --term=<12|24>',
            );
        }

        return new CliCommandInput(trim($amount), trim($term));
    }
}
