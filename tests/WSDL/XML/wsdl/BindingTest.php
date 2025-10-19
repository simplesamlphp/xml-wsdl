<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\XML\wsdl\AbstractBinding;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Binding;
use SimpleSAML\WSDL\XML\wsdl\BindingOperation;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationFault;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationInput;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationOutput;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Binding.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Binding::class)]
#[CoversClass(AbstractBinding::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BindingTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Binding::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/Binding.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Binding object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $operationChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OperationChunk</ssp:Chunk>',
        );
        $inputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">InputChunk</ssp:Chunk>',
        );
        $outputChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OutputChunk</ssp:Chunk>',
        );
        $faultOneChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultOneChunk</ssp:Chunk>',
        );
        $faultTwoChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">FaultTwoChunk</ssp:Chunk>',
        );

        $input = new BindingOperationInput(
            NCNameValue::fromString('CustomInputName'),
            [new Chunk($inputChild->documentElement)],
        );
        $output = new BindingOperationOutput(
            NCNameValue::fromString('CustomOutputName'),
            [new Chunk($outputChild->documentElement)],
        );
        $faultOne = new BindingOperationFault(
            NCNameValue::fromString('CustomFaultOne'),
            [new Chunk($faultOneChild->documentElement)],
        );
        $faultTwo = new BindingOperationFault(
            NCNameValue::fromString('CustomFaultTwo'),
            [new Chunk($faultTwoChild->documentElement)],
        );

        $operationOne = new BindingOperation(
            NCNameValue::fromString('OperationOne'),
            $input,
            $output,
            [$faultOne, $faultTwo],
            [new Chunk($operationChild->documentElement)],
        );
        $operationTwo = new BindingOperation(NCNameValue::fromString('OperationTwo'));

        $binding = new Binding(
            NCNameValue::fromString('MyBinding'),
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:CustomType'),
            [$operationOne, $operationTwo],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($binding),
        );
    }
}
