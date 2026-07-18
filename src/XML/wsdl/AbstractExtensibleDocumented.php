<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use Dom;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class representing the tExtensibleDocumented type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractExtensibleDocumented extends AbstractDocumented
{
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


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
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() && empty($this->elements);
    }


    /**
     * Convert this tExtensibleDocumented to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tExtensibleDocumented.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
