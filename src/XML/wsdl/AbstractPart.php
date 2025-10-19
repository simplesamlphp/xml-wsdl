<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

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
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\XMLSchema\Type\QNameValue|null $element
     * @param \SimpleSAML\XMLSchema\Type\QNameValue|null $type
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected NCNameValue $name,
        protected ?QNameValue $element = null,
        protected ?QNameValue $type = null,
        array $attributes = [],
    ) {
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
     * Collect the value of the element-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue|null
     */
    public function getElement(): ?QNameValue
    {
        return $this->element;
    }


    /**
     * Collect the value of the type-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue|null
     */
    public function getType(): ?QNameValue
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

        $e->setAttribute('name', $this->getName()->getValue());

        if ($this->getElement() !== null) {
            $e->setAttribute('element', $this->getElement()->getValue());
        }

        if ($this->getType() !== null) {
            $e->setAttribute('type', $this->getType()->getValue());
        }

        return $e;
    }
}
