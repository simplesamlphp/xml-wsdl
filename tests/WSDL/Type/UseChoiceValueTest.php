<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\Type;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;

/**
 * Class \SimpleSAML\Test\WSDL\Type\UseChoiceValueTest
 *
 * @package simplesamlphp/xml-wsdl
 */
#[CoversClass(UseChoiceValue::class)]
final class UseChoiceValueTest extends TestCase
{
    /**
     * @param string $useChoice
     * @param bool $shouldPass
     */
    #[DataProvider('provideUseChoice')]
    public function testUseChoiceValue(string $useChoice, bool $shouldPass): void
    {
        try {
            UseChoiceValue::fromString($useChoice);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * Test helpers
     */
    public function testHelpers(): void
    {
        $x = UseChoiceValue::fromEnum(UseChoiceEnum::Encoded);
        $this->assertEquals(UseChoiceEnum::Encoded, $x->toEnum());

        $y = UseChoiceValue::fromString('encoded');
        $this->assertEquals(UseChoiceEnum::Encoded, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideUseChoice(): array
    {
        return [
            'encoded' => ['encoded', true],
            'literal' => ['literal', true],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
