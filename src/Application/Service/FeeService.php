<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Service;

use Lendable\Interview\Application\Exception\ApplicationException;
use Lendable\Interview\Application\Repository\FeeRepositoryInterface;
use Lendable\Interview\Domain\Service\FeeCalculator;
use Lendable\Interview\Domain\ValueObject\Amount;
use Lendable\Interview\Domain\ValueObject\Term;
use Lendable\Interview\Infrastructure\DTO\CalculateFeeDTO;
use Lendable\Interview\Infrastructure\Service\FeeServiceInterface;

final readonly class FeeService implements FeeServiceInterface
{
    public function __construct(
        private FeeRepositoryInterface $repository,
        private FeeCalculator $calculator = new FeeCalculator(),
    ) {}

    public function calculate(CalculateFeeDTO $calculateFeeDTO): int
    {
        try {
            $amount = new Amount($calculateFeeDTO->amount);
            $term   = new Term($calculateFeeDTO->term);
            $breakpoints = $this->repository->getFeesForTerm($term);
            $fee = $this->calculator->calculate($amount, $breakpoints);
            $fee = $this->calculator->roundUpToFivePoundsTotal($amount->value(), $fee);
            return $fee;
        } catch (\Throwable $exception) {
            throw new ApplicationException('Cannot calculate fee' , 0, $exception);
        }
    }
}
