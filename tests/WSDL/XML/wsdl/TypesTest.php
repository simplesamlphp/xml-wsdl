<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Types;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Types.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Types::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class TypesTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Types::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/Types.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Types object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $types = new Types([new Chunk($child->documentElement)]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($types),
        );
    }
}
