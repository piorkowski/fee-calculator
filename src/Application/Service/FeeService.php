<?php

declare(strict_types=1);

namespace Interview\Application\Service;

use Interview\Application\Exception\ApplicationException;
use Interview\Application\Repository\FeeRepositoryInterface;
use Interview\Domain\Service\FeeCalculator;
use Interview\Domain\ValueObject\Amount;
use Interview\Domain\ValueObject\Term;
use Interview\Infrastructure\DTO\CalculateFeeDTO;
use Interview\Infrastructure\Service\FeeServiceInterface;

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
