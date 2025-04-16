<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tBindingOperationMessage type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBindingOperationMessage extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tBindingOperationMessage
     *
     * @param string|null $name
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected ?string $name = null,
        array $elements = [],
    ) {
        Assert::nullOrValidNCName($name, SchemaViolationException::class);
        parent::__construct($elements);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return string|null
     */
    public function getName(): ?string
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
        return parent::isEmptyElement() && empty($this->getName());
    }


    /**
     * Convert this tBindingOperationMessage to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBindingOperationMessage.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('name', $this->getName());
        }

        return $e;
    }
}
