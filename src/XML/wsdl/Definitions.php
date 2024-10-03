<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing the Definitions element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Definitions extends AbstractDefinitions
{
    /** @var string */
    final public const LOCALNAME = 'definitions';


    /**
     * Initialize a Definitions element.
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
            self::getOptionalAttribute($xml, 'targetNamespace'),
            self::getOptionalAttribute($xml, 'name'),
            Import::getChildrenOfClass($xml),
            Types::getChildrenOfClass($xml),
            Message::getChildrenOfClass($xml),
            PortType::getChildrenOfClass($xml),
            Binding::getChildrenOfClass($xml),
            Service::getChildrenOfClass($xml),
            self::getChildElementsFromXML($xml),
        );
    }
}
