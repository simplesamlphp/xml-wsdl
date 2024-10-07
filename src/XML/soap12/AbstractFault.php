<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function in_array;

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
     * @param string|null $encodingStyle
     * @param string|null $use
     * @param string|null $namespace
     * @param bool|null $required
     */
    final public function __construct(
        ?string $encodingStyle = null,
        ?string $use = null,
        ?string $namespace = null,
        ?bool $required = null,
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
            self::getOptionalAttribute($xml, 'encodingStyle'),
            self::getOptionalAttribute($xml, 'use'),
            self::getOptionalAttribute($xml, 'namespace'),
            $required,
        );
    }


    /**
     * Convert this tFault to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tFault
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        return parent::toXML($parent);
    }
}
