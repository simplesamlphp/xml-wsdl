<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;

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
     * Convert this tExtensibilityElement to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tExtensibilityElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getRequired() !== null) {
            $e->setAttribute('required', $this->getRequired() ? 'true' : 'false');
        }

        return $e;
    }
}
