<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use Dom;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

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
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue $name
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $binding
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected NCNameValue $name,
        protected QNameValue $binding,
        array $elements = [],
    ) {
        parent::__construct($elements);
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
     * Collect the value of the binding-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue
     */
    public function getBinding(): QNameValue
    {
        return $this->binding;
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
     * Convert this tPort to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tPort.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName()->getValue());
        $e->setAttribute('binding', $this->getBinding()->getValue());

        return $e;
    }
}
