<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use Dom;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Abstract class representing the tImport type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractImport extends AbstractExtensibleAttributesDocumented
{
    /**
     * Initialize a wsdl:tImport
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $namespace
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $location
     * @param array<\SimpleSAML\XML\Attribute> $attributes
     */
    public function __construct(
        protected AnyURIValue $namespace,
        protected AnyURIValue $location,
        array $attributes = [],
    ) {
        parent::__construct($attributes);
    }


    /**
     * Collect the value of the namespace-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getNamespace(): AnyURIValue
    {
        return $this->namespace;
    }


    /**
     * Collect the value of the location-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getLocation(): AnyURIValue
    {
        return $this->location;
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
     * Convert this tImport to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tImport.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        $e->setAttribute('namespace', $this->getNamespace()->getValue());
        $e->setAttribute('location', $this->getLocation()->getValue());

        return $e;
    }
}
