<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Abstract class representing the tAddress type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractAddress extends AbstractExtensibilityElement
{
    /** @var string */
    public const NS = C::NS_WSDL_SOAP_12;

    /** @var string */
    public const NS_PREFIX = 'soap12';

    /** @var string */
    public const LOCALNAME = 'address';

    /** @var string */
    public const SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:address
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $location
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    final public function __construct(
        protected AnyURIValue $location,
        ?RequiredValue $required = null,
    ) {
        parent::__construct($required);
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
     * Initialize a Address element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $required = null;
        if ($xml->hasAttributeNS(C::NS_WSDL, 'required')) {
            $required = RequiredValue::fromString($xml->getAttributeNS(C::NS_WSDL, 'required'));
        }

        return new static(
            self::getAttribute($xml, 'location', AnyURIValue::class),
            $required,
        );
    }


    /**
     * Convert this tBinding to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBinding
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);
        $e->setAttribute('location', $this->getLocation()->getValue());

        return $e;
    }
}
