<?php

declare(strict_types=1);

namespace Interview\Domain\Service;

use Interview\Domain\ValueObject\Amount;

final class FeeCalculator
{
    /**
     * @param array<array{amount: int, fee: int}> $breakpoints
     */
    public function calculate(Amount $amount, array $breakpoints): int
    {
        $amountValue = $amount->value();
        if (count($breakpoints) < 1) {
            return 0;
        }

        foreach ($breakpoints as $breakpoint) {
            if ($breakpoint['amount'] === $amountValue) {
                return $breakpoint['fee'];
            }
        }

        $lower = null;
        $upper = null;
        foreach ($breakpoints as $breakpoint) {
            if ($breakpoint['amount'] < $amountValue) {
                $lower = $breakpoint;
            }
            if ($breakpoint['amount'] > $amountValue) {
                $upper = $breakpoint;
                break;
            }
        }

        if ($lower === null) {
            return $breakpoints[0]['fee'];
        }
        if ($upper === null) {
            return $breakpoints[count($breakpoints) - 1]['fee'];
        }

        $amountLower = $lower['amount'];
        $feeLower = $lower['fee'];
        $amountUpper = $upper['amount'];
        $feeUpper = $upper['fee'];
        $deltaAmount = $amountUpper - $amountLower;
        $deltaFee = $feeUpper - $feeLower;
        $numerator = $deltaFee * ($amountValue - $amountLower);
        $increment = intdiv($numerator + $deltaAmount - 1, $deltaAmount);
        return $feeLower + $increment;
    }

    public function roundUpToFivePoundsTotal(int $amount, int $fee): int
    {
        $mod = ($amount + $fee) % 500;
        return $mod === 0 ? $fee : $fee + (500 - $mod);
    }
}
