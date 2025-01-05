<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WSDL\XML\wsdl;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractDefinitions;
use SimpleSAML\WSDL\XML\wsdl\AbstractDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibleDocumented;
use SimpleSAML\WSDL\XML\wsdl\AbstractWsdlElement;
use SimpleSAML\WSDL\XML\wsdl\Binding;
use SimpleSAML\WSDL\XML\wsdl\BindingOperation;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationFault;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationInput;
use SimpleSAML\WSDL\XML\wsdl\BindingOperationOutput;
use SimpleSAML\WSDL\XML\wsdl\Definitions;
use SimpleSAML\WSDL\XML\wsdl\Fault;
use SimpleSAML\WSDL\XML\wsdl\Import;
use SimpleSAML\WSDL\XML\wsdl\Input;
use SimpleSAML\WSDL\XML\wsdl\Message;
use SimpleSAML\WSDL\XML\wsdl\Output;
use SimpleSAML\WSDL\XML\wsdl\Part;
use SimpleSAML\WSDL\XML\wsdl\Port;
use SimpleSAML\WSDL\XML\wsdl\PortType;
use SimpleSAML\WSDL\XML\wsdl\PortTypeOperation as Operation;
use SimpleSAML\WSDL\XML\wsdl\Service;
use SimpleSAML\WSDL\XML\wsdl\Types;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsdl:Definitions.
 *
 * @package simplesamlphp/xml-wsdl
 */
#[Group('wsdl')]
#[CoversClass(Definitions::class)]
#[CoversClass(AbstractDefinitions::class)]
#[CoversClass(AbstractExtensibleDocumented::class)]
#[CoversClass(AbstractDocumented::class)]
#[CoversClass(AbstractWsdlElement::class)]
final class DefinitionsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Definitions::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsdl/Definitions.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Definitions object from scratch.
     */
    public function testMarshalling(): void
    {
        // Import
        $importAttr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $import = new Import('urn:x-simplesamlphp:namespace', 'urn:x-simplesamlphp:location', [$importAttr1]);

        // Types
        $typesChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">TypesChunk</ssp:Chunk>',
        );

        $types = new Types([new Chunk($typesChild->documentElement)]);

        // Message
        $messageChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">MessageChunk</ssp:Chunk>',
        );

        $messageAttr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $messageAttr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'value2');
        $part1 = new Part('CustomName', 'ssp:CustomElement', 'wsdl:part', [$messageAttr1]);

        $message = new Message('SomeName', [$part1], [new Chunk($messageChild->documentElement)]);

        // PortType
        $port = new XMLAttribute(C::NAMESPACE, 'ssp', 'port', '1234');
        $portAttr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', 'value1');
        $portAttr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', 'value2');
        $portAttr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', 'value3');

        $input = new Input('ssp:CustomInputMessage', 'CustomInputName', [$portAttr1]);
        $output = new Output('ssp:CustomOutputMessage', 'CustomOutputName', [$portAttr2]);
        $fault = new Fault('CustomFaultName', 'ssp:CustomFaultMessage', [$portAttr3]);

        $inputOperation = new Operation('Input', '0836217462 0836217463', $input, $output, [$fault]);

        $portType = new PortType('MyPort', [$inputOperation], [$port]);

        // Binding
        $bindingChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">BindingChunk</ssp:Chunk>',
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

        $input = new BindingOperationInput('CustomInputName', [new Chunk($inputChild->documentElement)]);
        $output = new BindingOperationOutput('CustomOutputName', [new Chunk($outputChild->documentElement)]);
        $faultOne = new BindingOperationFault('CustomFaultOne', [new Chunk($faultOneChild->documentElement)]);

        $operationOne = new BindingOperation(
            'OperationOne',
            $input,
            $output,
            [$faultOne],
            [new Chunk($operationChild->documentElement)],
        );

        $binding = new Binding(
            'MyBinding',
            'wsdl:binding',
            [$operationOne],
            [new Chunk($bindingChild->documentElement)],
        );

        // Service
        $serviceChild = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">ServiceChunk</ssp:Chunk>',
        );
        $chunkOne = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">ChunkOne</ssp:Chunk>',
        );
        $chunkTwo = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">ChunkTwo</ssp:Chunk>',
        );

        $portOne = new Port('PortOne', 'wsdl:binding', [new Chunk($chunkOne->documentElement)]);

        $service = new Service('MyService', [$portOne], [new Chunk($serviceChild->documentElement)]);

        // Child
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $definitions = new Definitions(
            'urn:x-simplesamlphp:namespace',
            'MyDefinitions',
            [$import],
            [$types],
            [$message],
            [$portType],
            [$binding],
            [$service],
            [new Chunk($child->documentElement)],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($definitions),
        );
    }
}
