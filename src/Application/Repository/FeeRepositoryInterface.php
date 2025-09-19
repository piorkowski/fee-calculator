<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Repository;

use Lendable\Interview\Domain\ValueObject\Amount;
use Lendable\Interview\Domain\ValueObject\Fee;
use Lendable\Interview\Domain\ValueObject\Term;

interface FeeRepositoryInterface
{
    public function getFee(Amount $amount, Term $term): Fee;

    /**
     * @return array<int, array{amount:int, fee:int}>
     */
    public function getFeesForTerm(Term $term): array;
}
