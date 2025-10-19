<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Abstract class representing the tBinding type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBinding extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tBinding
     *
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $type
     * @param \SimpleSAML\WSDL\XML\wsdl\BindingOperation[] $operation
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected NCNameValue $name,
        protected QNameValue $type,
        protected array $operation = [],
        array $elements = [],
    ) {
        Assert::allIsInstanceOf($operation, BindingOperation::class, SchemaViolationException::class);

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
     * Collect the value of the type-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue
     */
    public function getType(): QNameValue
    {
        return $this->type;
    }


    /**
     * Collect the value of the operation-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\BindingOperation[]
     */
    public function getOperation(): array
    {
        return $this->operation;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        // Upstream abstract elements can be empty, but this one cannot
        return false;
    }


    /**
     * Convert this tBinding to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBinding.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());
        $e->setAttribute('type', $this->getType()->getValue());

        foreach ($this->getOperation() as $operation) {
            $operation->toXML($e);
        }

        return $e;
    }
}
