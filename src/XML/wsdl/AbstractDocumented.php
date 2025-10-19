<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;

/**
 * Abstract class representing the tDocumented type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractDocumented extends AbstractWsdlElement
{
    /**
     * Initialize a wsdl:tDocumented
     *
     * @todo @param \SimpleSAML\WSDL\XML\wsdl\Documentation|null $documentation
     */
    public function __construct(
        //protected ?Documentation $documentation = null,
    ) {
    }


    /**
     * Get document
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Documentation|null
    public function getDocumentation(): ?Documentation
    {
        return $this->documentation;
    }
     */


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return /*empty($this->getDocumentation())*/ true;
    }


    /**
     * Convert this tDocumented to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tDocumented.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        //$this->getDocumentation()?->toXML($e);

        return $e;
    }
}
