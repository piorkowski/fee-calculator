<?php

declare(strict_types=1);

namespace Interview\Tests\Integration;

use Interview\Tests\IntegrationTester;

final class ServiceIntegrationCest
{
    public function invoke_command(IntegrationTester $I): void
    {
        $cmd = \Interview\UI\CLI\Command\CalculateFeeCommand::default();
        $out = $cmd('11500', '24');
        $I->assertSame('460.00', $out);
    }
}
