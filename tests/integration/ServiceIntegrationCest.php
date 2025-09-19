<?php

declare(strict_types=1);

namespace Lendable\Interview\Tests\Integration;

use Lendable\Interview\Tests\IntegrationTester;

final class ServiceIntegrationCest
{
    public function invoke_command(IntegrationTester $I): void
    {
        $cmd = \Lendable\Interview\UI\CLI\Command\CalculateFeeCommand::default();
        $out = $cmd('11500', '24');
        $I->assertSame('460.00', $out);
    }
}
