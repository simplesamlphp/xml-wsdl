<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;

/**
 * Abstract class representing the tBody type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBody extends AbstractExtensibilityElement
{
    use BodyAttributesTrait;


    public const string NS = C::NS_WSDL_SOAP_12;

    public const string NS_PREFIX = 'soap12';

    public const string LOCALNAME = 'body';

    public const string SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:body
     *
     * @param \SimpleSAML\XMLSchema\Type\NMTokensValue|null $parts
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $encodingStyle
     * @param \SimpleSAML\WSDL\Type\UseChoiceValue|null $use
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $namespace
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    public function __construct(
        protected ?NMTokensValue $parts = null,
        ?AnyURIValue $encodingStyle = null,
        ?UseChoiceValue $use = null,
        ?AnyURIValue $namespace = null,
        ?RequiredValue $required = null,
    ) {
        // Assertions are handled by the setters
        $this->setEncodingStyle($encodingStyle);
        $this->setUse($use);
        $this->setNamespace($namespace);

        parent::__construct($required);
    }


    /**
     * Collect the value of the parts-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NMTokensValue|null
     */
    public function getParts(): ?NMTokensValue
    {
        return $this->parts;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement()
            && empty($this->getParts())
            && empty($this->getEncodingStyle()
            && empty($this->getUse())
            && empty($this->getnamespace()));
    }


    /**
     * Convert this tBody to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBody
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getParts() !== null) {
            $e->setAttribute('parts', $this->getParts()->getValue());
        }

        if ($this->getEncodingStyle() !== null) {
            $e->setAttribute('encodingStyle', $this->getEncodingStyle()->getValue());
        }

        if ($this->getUse() !== null) {
            $e->setAttribute('use', $this->getUse()->getValue());
        }

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', $this->getNamespace()->getValue());
        }

        return $e;
    }
}
