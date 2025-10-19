<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Abstract class representing the tFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractFault extends AbstractBody
{
    /** @var string */
    public const LOCALNAME = 'fault';


    /**
     * Initialize a soap12:fault
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $encodingStyle
     * @param \SimpleSAML\WSDL\Type\UseChoiceValue|null $use
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $namespace
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    final public function __construct(
        ?AnyURIValue $encodingStyle = null,
        ?UseChoiceValue $use = null,
        ?AnyURIValue $namespace = null,
        ?RequiredValue $required = null,
    ) {
        parent::__construct(
            parts: null,
            encodingStyle: $encodingStyle,
            use: $use,
            namespace: $namespace,
            required: $required,
        );
    }


    /**
     * Initialize a Body element.
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
            self::getOptionalAttribute($xml, 'encodingStyle', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'use', UseChoiceValue::class),
            self::getOptionalAttribute($xml, 'namespace', AnyURIValue::class),
            $required,
        );
    }


    /**
     * Convert this tFault to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tFault
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        return parent::toXML($parent);
    }
}
