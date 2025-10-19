<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WSDL\XML\wsdl\AbstractBindingOperation;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\BindingOperation;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationFault;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationInput;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationOutput;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\NCNameValue;

use function dirname;
use function strval;

/**
 * Tests for wsdl:BindingOperation.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(BindingOperation::class)]
#[CoversClass(AbstractBindingOperation::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class BindingOperationTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = BindingOperation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/BindingOperation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an BindingOperation object from scratch.
     */
    public function testMarshalling(): void
    {
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
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

        $bindingOperation = new BindingOperation(
            NCNameValue::fromString('SomeName'),
            $input,
            $output,
            [$faultOne, $faultTwo],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($bindingOperation),
        );
    }
}
