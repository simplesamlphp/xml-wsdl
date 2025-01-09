<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tPort type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractPort extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tPort
     *
     * @param string $name
     * @param string $binding
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        protected string $binding,
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::validQName($binding, SchemaViolationException::class);

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
     * Collect the value of the binding-property.
     *
     * @return string
     */
    public function getBinding(): string
    {
        return $this->binding;
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
     * Convert this tPort to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tPort.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());
        $e->setAttribute('binding', $this->getBinding());

        return $e;
    }
}
