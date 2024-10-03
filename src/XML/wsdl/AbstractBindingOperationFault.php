<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tBindingOperationFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBindingOperationFault extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tBindingOperationFault
     *
     * @param string $name
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        parent::__construct($elements);
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
     * Convert this tBindingOperationFault to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBindingOperationFault.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);
        $e->setAttribute('name', $this->getName());

        return $e;
    }
}
