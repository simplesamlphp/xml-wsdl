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
use SimpleSAML\XMLSchema\Type\BooleanValue;

/**
 * Abstract class representing the tOperation type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractOperation extends AbstractExtensibilityElement
{
    public const string NS = C::NS_WSDL_SOAP_12;

    public const string NS_PREFIX = 'soap12';

    public const string LOCALNAME = 'operation';

    public const string SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:operation
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $soapAction
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $soapActionRequired
     * @param \SimpleSAML\WSDL\Type\StyleChoiceValue|null $style
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    final public function __construct(
        protected ?AnyURIValue $soapAction = null,
        protected ?BooleanValue $soapActionRequired = null,
        protected ?StyleChoiceValue $style = null,
        ?RequiredValue $required = null,
    ) {
        parent::__construct($required);
    }


    /**
     * Collect the value of the soapAction-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getSoapAction(): ?AnyURIValue
    {
        return $this->soapAction;
    }


    /**
     * Collect the value of the soapActionRequired-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getSoapActionRequired(): ?BooleanValue
    {
        return $this->soapActionRequired;
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
            self::getOptionalAttribute($xml, 'soapAction', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'soapActionRequired', BooleanValue::class),
            self::getOptionalAttribute($xml, 'style', StyleChoiceValue::class),
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
            $e->setAttribute('soapAction', $this->getSoapAction()->getValue());
        }

        if ($this->getSoapActionRequired() !== null) {
            $e->setAttribute('soapActionRequired', $this->getSoapActionRequired()->getValue());
        }

        if ($this->getStyle() !== null) {
            $e->setAttribute('style', $this->getStyle()->getValue());
        }

        return $e;
    }
}
