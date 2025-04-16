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
 * Abstract class representing the tOperation type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractOperation extends AbstractExtensibilityElement
{
    /** @var string */
    public const NS = C::NS_WSDL_SOAP_12;

    /** @var string */
    public const NS_PREFIX = 'soap12';

    /** @var string */
    public const LOCALNAME = 'operation';

    /** @var string */
    public const SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:operation
     *
     * @param string|null $soapAction
     * @param bool|null $soapActionRequired
     * @param string|null $style
     * @param bool|null $required
     */
    final public function __construct(
        protected ?string $soapAction = null,
        protected ?bool $soapActionRequired = null,
        protected ?string $style = null,
        ?bool $required = null,
    ) {
        Assert::nullOrValidURI($soapAction, SchemaViolationException::class);
        Assert::nullOrOneOf($style, ['rpc', 'document'], SchemaViolationException::class);

        parent::__construct($required);
    }


    /**
     * Collect the value of the soapAction-property.
     *
     * @return string|null
     */
    public function getSoapAction(): ?string
    {
        return $this->soapAction;
    }


    /**
     * Collect the value of the soapActionRequired-property.
     *
     * @return bool|null
     */
    public function getSoapActionRequired(): ?bool
    {
        return $this->soapActionRequired;
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
            && empty($this->getSoapAction())
            && empty($this->getSoapActionRequired())
            && empty($this->getStyle());
    }


    /**
     * Initialize an Operation element.
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
            self::getOptionalAttribute($xml, 'soapAction'),
            self::getOptionalBooleanAttribute($xml, 'soapActionRequired'),
            self::getOptionalAttribute($xml, 'style'),
            $required,
        );
    }


    /**
     * Convert this tOperation to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tOperation
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getSoapAction() !== null) {
            $e->setAttribute('soapAction', $this->getSoapAction());
        }

        if ($this->getSoapActionRequired() !== null) {
            $e->setAttribute('soapActionRequired', $this->getSoapActionRequired() ? 'true' : 'false');
        }

        if ($this->getStyle() !== null) {
            $e->setAttribute('style', $this->getStyle());
        }

        return $e;
    }
}
