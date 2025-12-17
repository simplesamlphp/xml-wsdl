<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\NCNameValue;

/**
 * Abstract class representing the tBindingOperation type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBindingOperation extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tBindingOperation
     *
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\WSDL\XML\wsdl\BindingOperationInput|null $input
     * @param \SimpleSAML\WSDL\XML\wsdl\BindingOperationOutput|null $output
     * @param \SimpleSAML\WSDL\XML\wsdl\BindingOperationFault[] $fault
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected NCNameValue $name,
        protected ?BindingOperationInput $input = null,
        protected ?BindingOperationOutput $output = null,
        protected array $fault = [],
        array $elements = [],
    ) {
        Assert::allIsInstanceOf($fault, BindingOperationFault::class, SchemaViolationException::class);

        parent::__construct($elements);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NCNameValue
     */
    public function getName(): NCNameValue
    {
        return $this->name;
    }


    /**
     * Collect the value of the input-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\BindingOperationInput|null
     */
    public function getInput(): ?BindingOperationInput
    {
        return $this->input;
    }


    /**
     * Collect the value of the output-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\BindingOperationOutput|null
     */
    public function getOutput(): ?BindingOperationOutput
    {
        return $this->output;
    }


    /**
     * Collect the value of the fault-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\BindingOperationFault[]
     */
    public function getFault(): array
    {
        return $this->fault;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        // Upstream abstract elements can be empty, but this one cannot
        return false;
    }


    /**
     * Convert this tBindingOperation to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBindingOperation.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());

        $this->getInput()?->toXML($e);
        $this->getOutput()?->toXML($e);

        foreach ($this->getFault() as $fault) {
            $fault->toXML($e);
        }

        return $e;
    }
}
