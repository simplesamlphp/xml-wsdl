<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\Type;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Enumeration\StyleChoiceEnum;
use SimpleSAML\WSDL\Type\StyleChoiceValue;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;

/**
 * Class \SimpleSAML\Test\WSDL\Type\StyleChoiceValueTest
 *
 * @package simplesamlphp/xml-wsdl
 */
#[CoversClass(StyleChoiceValue::class)]
final class StyleChoiceValueTest extends TestCase
{
    /**
     * @param string $styleChoice
     * @param bool $shouldPass
     */
    #[DataProvider('provideStyleChoice')]
    public function testStyleChoiceValue(string $styleChoice, bool $shouldPass): void
    {
        try {
            StyleChoiceValue::fromString($styleChoice);
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
        $x = StyleChoiceValue::fromEnum(StyleChoiceEnum::Document);
        $this->assertEquals(StyleChoiceEnum::Document, $x->toEnum());

        $y = StyleChoiceValue::fromString('document');
        $this->assertEquals(StyleChoiceEnum::Document, $y->toEnum());
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideStyleChoice(): array
    {
        return [
            'document' => ['document', true],
            'rpc' => ['rpc', true],
            'undefined' => ['undefined', false],
            'empty' => ['', false],
        ];
    }
}
