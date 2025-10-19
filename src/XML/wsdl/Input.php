<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Class representing the input-element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Input extends AbstractParam
{
    /** @var string */
    final public const LOCALNAME = 'input';


    /**
     * Initialize a input-element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::LOCALNAME, InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getAttribute($xml, 'message', QNameValue::class),
            self::getOptionalAttribute($xml, 'name', NCNameValue::class),
            self::getAttributesNSFromXML($xml),
        );
    }
}
