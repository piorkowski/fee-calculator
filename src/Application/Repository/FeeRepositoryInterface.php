<?php

declare(strict_types=1);

namespace Interview\Application\Repository;

use Interview\Domain\ValueObject\Amount;
use Interview\Domain\ValueObject\Fee;
use Interview\Domain\ValueObject\Term;

interface FeeRepositoryInterface
{
    public function getFee(Amount $amount, Term $term): Fee;

    /**
     * @return array<int, array{amount:int, fee:int}>
     */
    public function getFeesForTerm(Term $term): array;
}
