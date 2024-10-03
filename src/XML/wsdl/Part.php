<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the Part element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Part extends AbstractPart
{
    /** @var string */
    final public const LOCALNAME = 'part';


    /**
     * Initialize a Part element.
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
            self::getOptionalAttribute($xml, 'element'),
            self::getOptionalAttribute($xml, 'type'),
            self::getAttributesNSFromXML($xml),
        );
    }
}
