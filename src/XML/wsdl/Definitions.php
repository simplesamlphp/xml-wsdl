<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;

/**
 * Class representing the Definitions element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Definitions extends AbstractDefinitions implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    /** @var string */
    final public const LOCALNAME = 'definitions';

    /**
     * This element doesn't allow arbitrary namespace-declarations and therefore cannot be normalized
     * @var bool
     */
    final public const NORMALIZATION = false;


    /**
     * Initialize a Definitions element.
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
            self::getOptionalAttribute($xml, 'targetNamespace', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'name', NCNameValue::class),
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
