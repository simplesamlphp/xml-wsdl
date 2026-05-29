<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use Dom;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\NCNameValue;

/**
 * Abstract class representing the tPortType type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractPortType extends AbstractExtensibleAttributesDocumented
{
    /**
     * Initialize a wsdl:tPortType
     *
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\WSDL\XML\wsdl\PortTypeOperation[] $operation
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected NCNameValue $name,
        protected array $operation = [],
        array $attributes = [],
    ) {
        Assert::allIsInstanceOf($operation, PortTypeOperation::class, SchemaViolationException::class);

        parent::__construct($attributes);
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
     * Collect the value of the operation-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\PortTypeOperation[]
     */
    public function getOperation(): array
    {
        return $this->operation;
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
     * Convert this tPortType to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tPortType.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());

        foreach ($this->getOperation() as $operation) {
            $operation->toXML($e);
        }

        return $e;
    }
}
