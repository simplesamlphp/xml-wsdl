<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;

/**
 * Class representing the Service element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Service extends AbstractService
{
    /** @var string */
    final public const LOCALNAME = 'service';


    /**
     * Initialize a Service element.
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
            self::getAttribute($xml, 'name', NCNameValue::class),
            Port::getChildrenOfClass($xml),
            self::getChildElementsFromXML($xml),
        );
    }
}
