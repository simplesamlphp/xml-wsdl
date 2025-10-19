<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\StyleChoiceValue;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

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

    /** @var string */
    public const SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:binding
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $transport
     * @param \SimpleSAML\WSDL\Type\StyleChoiceValue|null $style
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    final public function __construct(
        protected ?AnyURIValue $transport = null,
        protected ?StyleChoiceValue $style = null,
        ?RequiredValue $required = null,
    ) {
        parent::__construct($required);
    }


    /**
     * Collect the value of the transport-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getTransport(): ?AnyURIValue
    {
        return $this->transport;
    }


    /**
     * Collect the value of the style-property.
     *
     * @return \SimpleSAML\WSDL\Type\StyleChoiceValue|null
     */
    public function getStyle(): ?StyleChoiceValue
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
            self::getOptionalAttribute($xml, 'transport', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'style', StyleChoiceValue::class),
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

        if ($this->getTransport() !== null) {
            $e->setAttribute('transport', $this->getTransport()->getValue());
        }

        if ($this->getStyle() !== null) {
            $e->setAttribute('style', $this->getStyle()->getValue());
        }

        return $e;
    }
}
