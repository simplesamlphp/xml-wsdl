<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tPart type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractPart extends AbstractExtensibleAttributesDocumented
{
    /**
     * Initialize a wsdl:tPart
     *
     * @param string $name
     * @param string|null $element
     * @param string|null $type
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected string $name,
        protected ?string $element = null,
        protected ?string $type = null,
        array $attributes = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::nullOrValidQName($element, SchemaViolationException::class);
        Assert::nullOrValidQName($type, SchemaViolationException::class);

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
     * Collect the value of the element-property.
     *
     * @return string|null
     */
    public function getElement(): ?string
    {
        return $this->element;
    }


    /**
     * Collect the value of the type-property.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
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
     * Convert this tPart to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tPart.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());

        if ($this->getElement() !== null) {
            $e->setAttribute('element', $this->getElement());
        }

        if ($this->getType() !== null) {
            $e->setAttribute('type', $this->getType());
        }

        return $e;
    }
}
