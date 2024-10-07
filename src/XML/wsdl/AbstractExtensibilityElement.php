<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XML\Attribute as XMLAttribute;

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
     * @param bool|null $required
     */
    public function __construct(
        protected ?bool $required = null,
    ) {
    }


    /**
     * Collect the value of the required-property.
     *
     * @return bool|null
     */
    public function getRequired(): ?bool
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
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getRequired() !== null) {
            $attr = new XMLAttribute(C::NS_WSDL, 'wsdl', 'required', $this->getRequired() ? 'true' : 'false');
            $attr->toXML($e);
        }

        return $e;
    }
}
