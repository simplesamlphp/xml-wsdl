<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\soap12\AbstractBody;
use SimpleSAML\WSDL\XML\soap12\Body;
use SimpleSAML\WSDL\XML\soap12\BodyAttributesTrait;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;

use function dirname;
use function strval;

/**
 * Tests for soap12:Body.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Body::class)]
#[CoversClass(BodyAttributesTrait::class)]
#[CoversClass(AbstractBody::class)]
#[CoversClass(AbstractExtensibilityElement::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BodyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Body::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/Body.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Body object from scratch.
     */
    public function testMarshalling(): void
    {
        $body = new Body(
            NMTokensValue::fromString('foo bar'),
            AnyURIValue::fromString('urn:x-simplesamlphp:coding'),
            UseChoiceValue::fromEnum(UseChoiceEnum::Literal),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            RequiredValue::fromBoolean(true),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body),
        );
    }


    /**
     * Adding an empty Body element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $wsdl_soap12 = C::NS_WSDL_SOAP_12;
        $body = new Body();
        $this->assertEquals(
            "<soap12:body xmlns:soap12=\"$wsdl_soap12\"/>",
            strval($body),
        );
        $this->assertTrue($body->isEmptyElement());
    }
}
