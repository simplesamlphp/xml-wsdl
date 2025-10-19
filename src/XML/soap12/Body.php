<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;

/**
 * Class representing the Body element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Body extends AbstractBody implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


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
            self::getOptionalAttribute($xml, 'parts', NMTokensValue::class),
            self::getOptionalAttribute($xml, 'encodingStyle', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'use', UseChoiceValue::class),
            self::getOptionalAttribute($xml, 'namespace', AnyURIValue::class),
            $required,
        );
    }
}
