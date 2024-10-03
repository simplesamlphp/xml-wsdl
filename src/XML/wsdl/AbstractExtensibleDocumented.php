<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\XsNamespace as NS;

/**
 * Abstract class representing the tExtensibleDocumented type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractExtensibleDocumented extends AbstractDocumented
{
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /**
     * Initialize a wsdl:tDocumented
     *
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(array $elements)
    {
        parent::__construct(/* TODO wsdl:documentation not implemented */);
        $this->setElements($elements);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() && empty($this->elements);
    }


    /**
     * Convert this tExtensibleDocumented to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tExtensibleDocumented.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
