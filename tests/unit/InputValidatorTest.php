<?php

declare(strict_types=1);

namespace Interview\Tests\Unit;

use Interview\UI\DTO\CliCommandInput;
use Interview\UI\Exception\InvalidCliInputException;
use Interview\UI\Validator\InputValidator;
use PHPUnit\Framework\TestCase;

final class InputValidatorTest extends TestCase
{
    public function testValidInputNormalized(): void
    {
        $validator = new InputValidator();
        $input = $validator->validate(new CliCommandInput('11,500.25', '24'));
        self::assertSame('11500.25', $input->amount);
        self::assertSame('24', $input->term);
    }

    public function testValidInputWithSpacesAndCommas(): void
    {
        $validator = new InputValidator();
        $input = $validator->validate(new CliCommandInput(' 11, 500.25 ', ' 24 '));
        self::assertSame('11500.25', $input->amount);
        self::assertSame('24', $input->term);
    }

    public function testRejectsNegativeAmount(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Amount cannot be negative');
        $validator->validate(new CliCommandInput('-1000', '12'));
    }

    public function testRejectsNonNumericAmount(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Amount must be a number');
        $validator->validate(new CliCommandInput('abc', '12'));
    }

    public function testRejectsInvalidAmountFormat(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Invalid amount format. Example: 11500 or 11,500.25');
        $validator->validate(new CliCommandInput('10.123', '12'));
    }

    public function testRejectsAmountBelowRange(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Amount must be between 1000 and 20000.');
        $validator->validate(new CliCommandInput('999.99', '12'));
    }

    public function testRejectsAmountAboveRange(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Amount must be between 1000 and 20000.');
        $validator->validate(new CliCommandInput('20000.01', '12'));
    }

    public function testRejectsNonNumericTerm(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Term must be numeric (12 or 24)');
        $validator->validate(new CliCommandInput('11500', 'abc'));
    }

    public function testRejectsInvalidTerm(): void
    {
        $validator = new InputValidator();
        $this->expectException(InvalidCliInputException::class);
        $this->expectExceptionMessage('Invalid term: must be 12 or 24 months');
        $validator->validate(new CliCommandInput('11500', '18'));
    }
}
