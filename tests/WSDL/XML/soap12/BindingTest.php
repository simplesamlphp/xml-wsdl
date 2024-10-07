<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityDocument;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\soap12\AbstractBinding;
use SimpleSAML\WSDL\XML\soap12\Binding;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for soap12:Binding.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Binding::class)]
#[CoversClass(AbstractBinding::class)]
#[CoversClass(AbstractExtensibilityDocument::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BindingTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Binding::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/wsdl-soap12.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/Binding.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Binding object from scratch.
     */
    public function testMarshalling(): void
    {
        $binding = new Binding('https://example.org/transport', 'rpc', true);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binding),
        );
    }
}