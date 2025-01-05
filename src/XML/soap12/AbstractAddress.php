<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function in_array;

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
     * @param string $location
     * @param bool|null $required
     */
    final public function __construct(
        protected string $location,
        ?bool $required = null,
    ) {
        Assert::validURI($location, SchemaViolationException::class);

        parent::__construct($required);
    }


    /**
     * Collect the value of the location-property.
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }


    /**
     * Initialize a Address element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $required = null;
        if ($xml->hasAttributeNS(C::NS_WSDL, 'required')) {
            $required = $xml->getAttributeNS(C::NS_WSDL, 'required');
            Assert::oneOf($required, ['0', '1', 'false', 'true'], SchemaViolationException::class);
            $required = in_array($required, ['1', 'true'], true);
        }

        return new static(
            self::getOptionalAttribute($xml, 'location'),
            $required,
        );
    }


    /**
     * Convert this tBinding to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBinding
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getLocation() !== null) {
            $e->setAttribute('location', $this->getLocation());
        }

        return $e;
    }
}
