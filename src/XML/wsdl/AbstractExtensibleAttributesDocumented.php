<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class representing the tExtensibleAttributesDocumented type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractExtensibleAttributesDocumented extends AbstractDocumented
{
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * Initialize a wsdl:tExtensibleAttributesDocumented
     *
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(/* TODO wsdl:documentation not implemented */);
        $this->setAttributesNS($attributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() && empty($this->getAttributesNS());
    }


    /**
     * Convert this tExtensibleAttributesDocumented to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tExtensibleAttributesDocumented.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
