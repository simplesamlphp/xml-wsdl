<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractPortTypeOperation;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Fault;
use SimpleSAML\WSDL\XML\wsdl\Input;
use SimpleSAML\WSDL\XML\wsdl\Output;
use SimpleSAML\WSDL\XML\wsdl\PortTypeOperation as Operation;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Operation.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Operation::class)]
#[CoversClass(AbstractPortTypeOperation::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class PortTypeOperationOutputTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Operation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/PortTypeOperation_Output.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Operation object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('value2'));
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', StringValue::fromString('value3'));

        $input = new Input(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomInputMessage'),
            NCNameValue::fromString('CustomInputName'),
            [$attr2],
        );

        $output = new Output(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomOutputMessage'),
            NCNameValue::fromString('CustomOutputName'),
            [$attr1],
        );

        $fault = new Fault(
            NCNameValue::fromString('CustomFaultName'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomFaultMessage'),
            [$attr3],
        );

        $operation = new Operation(
            NCNameValue::fromString('CustomName'),
            NMTokensValue::fromString('0836217462 0836217463'),
            $output,
            $input,
            [$fault],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($operation),
        );
    }
}
