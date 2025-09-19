<?php

declare(strict_types=1);

namespace Lendable\Interview\Tests\Unit;

use Lendable\Interview\Application\Service\FeeService;
use Lendable\Interview\Infrastructure\DTO\CalculateFeeDTO;
use Lendable\Interview\Infrastructure\Repository\InMemoryFeeRepository;
use PHPUnit\Framework\TestCase;

final class FeeServiceTest extends TestCase
{
    private FeeService $service;

    protected function setUp(): void
    {
        $this->service = new FeeService(new InMemoryFeeRepository());
    }

    public function testExactBreakpoint12M(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('1000', '12'));
        self::assertSame(5000, $fee);
    }

    public function testExactBreakpoint24M(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('20000', '24'));
        self::assertSame(80000, $fee);
    }

    public function testInterpolationMidpoint12M(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('10500', '12'));
        self::assertSame(21000, $fee);
    }

    public function testInterpolationMidpoint24M(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('11500', '24'));
        self::assertSame(46000, $fee);
    }

    public function testRoundingRuleTotalMultipleOf5Pounds(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('1000.01', '12'));
        self::assertSame(5499, $fee);
        self::assertSame(0, (100001 + $fee) % 500);
    }

    public function testBoundaryMinAmount(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('1000.00', '12'));
        self::assertSame(5000, $fee);
    }

    public function testBoundaryMaxAmount(): void
    {
        $fee = $this->service->calculate(new CalculateFeeDTO('20000.00', '12'));
        self::assertSame(40000, $fee);
    }
}
