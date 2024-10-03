<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleAttributesDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Part;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Part.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Part::class)]
#[CoversClass(AbstractExtensibleAttributesDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class PartTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Part::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/Part.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Part object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $part = new Part('CustomName', 'ssp:CustomElement', 'ssp:CustomType', [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($part),
        );
    }
}
