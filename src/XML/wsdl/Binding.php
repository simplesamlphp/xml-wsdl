<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Class representing the Binding element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Binding extends AbstractBinding
{
    /** @var string */
    final public const LOCALNAME = 'binding';


    /**
     * Initialize a Binding element.
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

        $operation = BindingOperation::getChildrenOfClass($xml);

        return new static(
            self::getAttribute($xml, 'name', NCNameValue::class),
            self::getAttribute($xml, 'type', QNameValue::class),
            $operation,
            self::getChildElementsFromXML($xml),
        );
    }
}
