<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the PortType element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class PortType extends AbstractPortType
{
    /** @var string */
    final public const LOCALNAME = 'portType';


    /**
     * Initialize a PortType element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::LOCALNAME, InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getAttribute($xml, 'name'),
            PortTypeOperation::getChildrenOfClass($xml),
            self::getAttributesNSFromXML($xml),
        );
    }
}
