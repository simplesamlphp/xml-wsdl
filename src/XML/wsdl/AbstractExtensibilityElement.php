<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Type\RequiredValue;

/**
 * Abstract class representing the tExtensibilityElement type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractExtensibilityElement extends AbstractWsdlElement
{
    /**
     * Initialize a wsdl:tExtensibilityElement
     *
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    public function __construct(
        protected ?RequiredValue $required = null,
    ) {
    }


    /**
     * Collect the value of the required-property.
     *
     * @return \SimpleSAML\WSDL\Type\RequiredValue|null
     */
    public function getRequired(): ?RequiredValue
    {
        return $this->required;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getRequired());
    }


    /**
     * Convert this tExtensibilityElement to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tExtensibilityElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $this->getRequired()?->toAttribute()->toXML($e);

        return $e;
    }
}
