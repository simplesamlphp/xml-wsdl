<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\soap12\AbstractHeader;
use SimpleSAML\WSDL\XML\soap12\Header;
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
 * Tests for soap12:Header.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Header::class)]
#[CoversClass(AbstractHeader::class)]
#[CoversClass(AbstractExtensibilityElement::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class HeaderTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Header::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/Header.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Header object from scratch.
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

        $header = new Header(
            QNameValue::fromString('{http://schemas.xmlsoap.org/wsdl/soap12/}soap12:tOperation'),
            NMTokensValue::fromString('foo bar'),
            UseChoiceValue::fromEnum(UseChoiceEnum::Literal),
            [$headerFault],
            AnyURIValue::fromString('urn:x-simplesamlphp:coding'),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            RequiredValue::fromBoolean(true),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($header),
        );
    }
}
