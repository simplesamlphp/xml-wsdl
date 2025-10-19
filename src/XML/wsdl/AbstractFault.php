<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Abstract class representing the tFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractFault extends AbstractExtensibleAttributesDocumented
{
    /**
     * Initialize a wsdl:tFault
     *
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $message
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected NCNameValue $name,
        protected QNameValue $message,
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
     * Collect the value of the message-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue
     */
    public function getMessage(): QNameValue
    {
        return $this->message;
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
     * Convert this tParam to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tParam.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());
        $e->setAttribute('message', $this->getMessage()->getValue());

        return $e;
    }
}
