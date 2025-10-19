<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\soap12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\soap12\AbstractBody;
use SimpleSAML\WSDL\XML\soap12\AbstractFault;
use SimpleSAML\WSDL\XML\soap12\BodyAttributesTrait;
use SimpleSAML\WSDL\XML\soap12\Fault;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;
use function strval;

/**
 * Tests for soap12:Fault.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Fault::class)]
#[CoversClass(AbstractFault::class)]
#[CoversClass(BodyAttributesTrait::class)]
#[CoversClass(AbstractBody::class)]
#[CoversClass(AbstractExtensibilityElement::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class FaultTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Fault::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/soap12/Fault.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Fault object from scratch.
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            AnyURIValue::fromString('urn:x-simplesamlphp:coding'),
            UseChoiceValue::fromEnum(UseChoiceEnum::Literal),
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            RequiredValue::fromBoolean(true),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($fault),
        );
    }
}
