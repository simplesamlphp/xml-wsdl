<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\XMLSchema\Type\NCNameValue;

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
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue|null $name
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected ?NCNameValue $name = null,
        array $elements = [],
    ) {
        parent::__construct($elements);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NCNameValue|null
     */
    public function getName(): ?NCNameValue
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
            $e->setAttribute('name', $this->getName()->getValue());
        }

        return $e;
    }
}
