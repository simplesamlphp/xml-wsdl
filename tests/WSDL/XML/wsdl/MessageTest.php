<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Message;
use SimpleSAML\WSDL\XML\wsdl\Part;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Message.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Message::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class MessageTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Message::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/Message.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Message object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('value2'));

        $part1 = new Part(
            NCNameValue::fromString('CustomName'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomElement'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomType'),
            [$attr1],
        );
        $part2 = new Part(
            NCNameValue::fromString('CustomOtherName'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomElement'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomType'),
            [$attr2],
        );

        $message = new Message(
            NCNameValue::fromString('SomeName'),
            [$part1, $part2],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($message),
        );
    }


    /**
     * Test creating an Message object with multiple parts with the same name fails.
     */
    public function testMarshallingMultiplePartsSameName(): void
    {
        $part1 = new Part(
            NCNameValue::fromString('CustomSameName'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomElement'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomType'),
        );

        $part2 = new Part(
            NCNameValue::fromString('CustomSameName'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomElement'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomType'),
        );

        $this->expectException(SchemaViolationException::class);
        new Message(NCNameValue::fromString('SomeName'), [$part1, $part2]);
    }
}
