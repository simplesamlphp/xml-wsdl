<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use Dom;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
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
     */
    public function isEmptyElement(): bool
    {
        // Upstream abstract elements can be empty, but this one cannot
        return false;
    }


    /**
     * Convert this tParam to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tParam.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());

        if (!$e->lookupPrefix($this->getMessage()->getNamespacePrefix()->getValue())) {
            $namespace = new XMLAttribute(
                C::NS_XMLNS,
                'xmlns',
                $this->getMessage()->getNamespacePrefix()->getValue(),
                $this->getMessage()->getNamespaceURI(),
            );
            $namespace->toXML($e);
        }

        $e->setAttribute('message', $this->getMessage()->getValue());

        return $e;
    }
}
