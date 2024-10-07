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
 * Abstract class representing the tBinding type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBinding extends AbstractExtensibilityElement
{
    /** @var string */
    public const NS = C::NS_WSDL_SOAP_12;

    /** @var string */
    public const NS_PREFIX = 'soap12';

    /** @var string */
    public const LOCALNAME = 'binding';


    /**
     * Initialize a soap12:binding
     *
     * @param string|null $transport
     * @param string|null $style
     * @param bool|null $required
     */
    final public function __construct(
        protected ?string $transport = null,
        protected ?string $style = null,
        ?bool $required = null,
    ) {
        Assert::nullOrValidURI($transport, SchemaViolationException::class);
        Assert::nullOrOneOf($style, ['rpc', 'document'], SchemaViolationException::class);

        parent::__construct($required);
    }


    /**
     * Collect the value of the transport-property.
     *
     * @return string|null
     */
    public function getTransport(): ?string
    {
        return $this->transport;
    }


    /**
     * Collect the value of the style-property.
     *
     * @return string|null
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement()
            && empty($this->getTransport())
            && empty($this->getStyle());
    }


    /**
     * Initialize a Binding element.
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
            self::getOptionalAttribute($xml, 'transport'),
            self::getOptionalAttribute($xml, 'style'),
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

        if ($this->getTransport() !== null) {
            $e->setAttribute('transport', $this->getTransport());
        }

        if ($this->getStyle() !== null) {
            $e->setAttribute('style', $this->getStyle());
        }

        return $e;
    }
}
