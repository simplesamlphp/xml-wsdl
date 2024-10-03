<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

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
     * @param string $name
     * @param \SimpleSAML\WSDL\XML\wsdl\PortTypeOperation[] $operation
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected string $name,
        protected array $operation = [],
        array $attributes = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::allIsInstanceOf($operation, PortTypeOperation::class, SchemaViolationException::class);

        parent::__construct($attributes);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return string
     */
    public function getName(): string
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
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        // Upstream abstract elements can be empty, but this one cannot
        return false;
    }


    /**
     * Convert this tPortType to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tPortType.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());

        foreach ($this->getOperation() as $operation) {
            $operation->toXML($e);
        }

        return $e;
    }
}
