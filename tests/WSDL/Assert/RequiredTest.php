<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\Assert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WSDL\Assert\Assert;

/**
 * Class \SimpleSAML\Test\WSDL\Assert\MustUnderstandTest
 *
 * @package simplesamlphp/xml-wsdl
 */
#[CoversClass(Assert::class)]
final class RequiredTest extends TestCase
{
    /**
     * @param boolean $shouldPass
     * @param string $required
     */
    #[DataProvider('provideInvalidRequired')]
    #[DataProvider('provideValidRequired')]
    public function testValidRequired(bool $shouldPass, string $required): void
    {
        try {
            Assert::validRequired($required);
            $this->assertTrue($shouldPass);
        } catch (AssertionFailedException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: true, 1: string}>
     */
    public static function provideValidRequired(): array
    {
        return [
            'one' => [true, '1'],
            'zero' => [true, '0'],
            'true' => [true, 'true'],
            'false' => [true, 'false'],
        ];
    }


    /**
     * @return array<string, array{0: false, 1: string}>
     */
    public static function provideInvalidRequired(): array
    {
        return [
            'vrai' => [false, 'vrai'],
            'faux' => [false, 'faux'],
        ];
    }
}
