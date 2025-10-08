<?php

declare(strict_types=1);

namespace Interview\Tests\Acceptance;

use Interview\Tests\AcceptanceTester;

final class CalculateFeeCest
{
    public function happyPath24M(AcceptanceTester $I): void
    {
        $I->runShellCommand('php bin/calculate-fee 11500 24');
        $I->seeInShellOutput('460.00');
    }

    public function happyPath12M(AcceptanceTester $I): void
    {
        $I->runShellCommand('php bin/calculate-fee 19250 12');
        $I->seeInShellOutput('385.00');
    }

    public function roundingEdge(AcceptanceTester $I): void
    {
        $I->runShellCommand('php bin/calculate-fee 1000.01 12');
        $I->seeInShellOutput('54.99');
    }

    public function invalidTerm(AcceptanceTester $I): void
    {
        $I->runShellCommand('php bin/calculate-fee 11500 18');
        $I->seeInShellOutput('Invalid term: must be 12 or 24 months');
    }

    public function missingArgs(AcceptanceTester $I): void
    {
        $I->runShellCommand('php bin/calculate-fee 11500');
        $I->seeInShellOutput('Usage: php bin/calculate-fee');
    }
}
