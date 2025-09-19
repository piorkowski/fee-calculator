<?php

declare(strict_types=1);

namespace Lendable\Interview\UI\Validator;

use Lendable\Interview\UI\DTO\CliCommandInput;
use Lendable\Interview\UI\Exception\InvalidCliInputException;

final class InputValidator
{
    public function validate(CliCommandInput $input): CliCommandInput
    {
        $amount = trim($input->amount);
        $term   = trim($input->term);

        if (str_starts_with($amount, '-')) {
            throw new InvalidCliInputException('Amount cannot be negative');
        }

        $normalizedAmount = str_replace([' ', ','], '', $amount);
        if (false === is_numeric($normalizedAmount)) {
            throw new InvalidCliInputException('Amount must be a number');
        }

        if (!preg_match('/^\+?\d+(?:\.\d{1,2})?$/', $normalizedAmount)) {
            throw new InvalidCliInputException('Invalid amount format. Example: 11500 or 11,500.25');
        }

        $amountValue = (float) $normalizedAmount;
        if ($amountValue < 1000 || $amountValue > 20000) {
            throw new InvalidCliInputException('Amount must be between 1000 and 20000.');
        }

        if (!preg_match('/^\d+$/', $term)) {
            throw new InvalidCliInputException('Term must be numeric (12 or 24)');
        }
        $termInt = (int) $term;
        if (!in_array($termInt, [12, 24], true)) {
            throw new InvalidCliInputException('Invalid term: must be 12 or 24 months');
        }

        return new CliCommandInput($normalizedAmount, (string) $termInt);
    }
}
