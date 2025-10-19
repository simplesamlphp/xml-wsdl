<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\soap12\AbstractHeaderFault;
use SimpleSAML\WSDL\XML\soap12\BodyAttributesTrait;
use SimpleSAML\WSDL\XML\soap12\HeaderFault;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Tests for soap12:HeaderFault.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(HeaderFault::class)]
#[CoversClass(BodyAttributesTrait::class)]
#[CoversClass(AbstractHeaderFault::class)]
#[CoversClass(AbstractExtensibilityElement::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class HeaderFaultTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = HeaderFault::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/HeaderFault.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an HeaderFault object from scratch.
     */
    public function testMarshalling(): void
    {
        $headerFault = new HeaderFault(
            QNameValue::fromString('{http://schemas.xmlsoap.org/wsdl/soap12/}soap12:tOperation'),
            NMTokensValue::fromString('foo bar'),
            UseChoiceValue::fromEnum(UseChoiceEnum::Literal),
            AnyURIValue::fromString('urn:x-simplesamlphp:coding'),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($headerFault),
        );
    }
}
