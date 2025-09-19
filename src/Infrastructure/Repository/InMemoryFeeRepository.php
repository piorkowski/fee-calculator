<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Repository;

use Lendable\Interview\Application\Repository\FeeRepositoryInterface;
use Lendable\Interview\Domain\ValueObject\Amount;
use Lendable\Interview\Domain\ValueObject\Fee;
use Lendable\Interview\Domain\ValueObject\Term;
use Lendable\Interview\Infrastructure\Exception\FeeNotFoundException;

class InMemoryFeeRepository implements FeeRepositoryInterface
{
    /** @var array<int, array<int, int>> $breakpoints */
    private static array $breakpoints = [
        12 => [
            1000 => 50,
            2000 => 90,
            3000 => 90,
            4000 => 115,
            5000 => 100,
            6000 => 120,
            7000 => 140,
            8000 => 160,
            9000 => 180,
            10000 => 200,
            11000 => 220,
            12000 => 240,
            13000 => 260,
            14000 => 280,
            15000 => 300,
            16000 => 320,
            17000 => 340,
            18000 => 360,
            19000 => 380,
            20000 => 400,
        ],
        24 => [
            1000 => 70,
            2000 => 100,
            3000 => 120,
            4000 => 160,
            5000 => 200,
            6000 => 240,
            7000 => 280,
            8000 => 320,
            9000 => 360,
            10000 => 400,
            11000 => 440,
            12000 => 480,
            13000 => 520,
            14000 => 560,
            15000 => 600,
            16000 => 640,
            17000 => 680,
            18000 => 720,
            19000 => 760,
            20000 => 800,
        ],
    ];

    public function getFee(Amount $amount, Term $term): Fee
    {
        $amountPounds = intdiv($amount->value(), 100);
        $feePounds = self::$breakpoints[$term->value()][$amountPounds] ?? null;

        if ($feePounds === null) {
            throw new FeeNotFoundException(
                sprintf('No fee defined for amount: %d in term: %d', $amount->value(), $term->value()),
            );
        }

        return new Fee($feePounds * 100);
    }

    /**
     * @return array<int, array{amount: int, fee: int}>
     */
    public function getFeesForTerm(Term $term): array
    {
        $termValue = $term->value();

        if (!isset(self::$breakpoints[$termValue])) {
            throw new FeeNotFoundException(
                sprintf('No fees defined for term: %d', $termValue),
            );
        }

        $list = [];
        foreach (self::$breakpoints[$termValue] as $amountPounds => $feePounds) {
            $list[] = ['amount' => $amountPounds * 100, 'fee' => $feePounds * 100];
        }

        return $list;
    }
}
