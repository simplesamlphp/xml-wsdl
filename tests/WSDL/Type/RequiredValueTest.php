<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\Type;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Assert\RequiredTest;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;

/**
 * Class \SimpleSAML\Test\WSDL\Type\RequiredValueTest
 *
 * @package simplesamlphp/xml-wsdl
 */
#[CoversClass(RequiredValue::class)]
final class RequiredValueTest extends TestCase
{
    /**
     * @param boolean $shouldPass
     * @param string $required
     */
    #[DataProvider('provideInvalidRequired')]
    #[DataProvider('provideValidRequired')]
    #[DataProviderExternal(RequiredTest::class, 'provideValidRequired')]
    #[DependsOnClass(RequiredTest::class)]
    public function testRequired(bool $shouldPass, string $required): void
    {
        try {
            RequiredValue::fromString($required);
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
        $x = RequiredValue::fromBoolean(false);
        $this->assertFalse($x->toBoolean());

        $y = RequiredValue::fromString('1');
        $this->assertTrue($y->toBoolean());

        //
        $required = RequiredValue::fromString('1');
        $attr = $required->toAttribute();

        $this->assertEquals($attr->getNamespaceURI(), C::NS_WSDL);
        $this->assertEquals($attr->getNamespacePrefix(), 'wsdl');
        $this->assertEquals($attr->getAttrName(), 'required');
        $this->assertEquals($attr->getAttrValue(), '1');
    }


    /**
     * @return array<string, array{0: true, 1: string}>
     */
    public static function provideValidRequired(): array
    {
        return [
            'whitespace collapse true' => [true, " 1 \n"],
            'whitespace collapse false' => [true, " 0 \n"],
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
