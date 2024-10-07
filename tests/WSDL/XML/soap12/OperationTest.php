<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\XML\soap12\AbstractOperation;
use SimpleSAML\WSDL\XML\soap12\Operation;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for soap12:Operation.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Operation::class)]
#[CoversClass(AbstractOperation::class)]
#[CoversClass(AbstractExtensibilityElement::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class OperationTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Operation::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/wsdl-soap12.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/Operation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Operation object from scratch.
     */
    public function testMarshalling(): void
    {
        $operation = new Operation('https://example.org/action', true, 'rpc', true);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($operation),
        );

        $this->assertFalse($operation->isEmptyElement());
    }
}
