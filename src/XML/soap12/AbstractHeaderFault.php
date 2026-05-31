<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use Dom;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Abstract class representing the tHeaderFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractHeaderFault extends AbstractSoapElement
{
    use BodyAttributesTrait;


    public const string LOCALNAME = 'headerfault';


    /**
     * Initialize a soap12:body
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $message
     * @param \SimpleSAML\XMLSchema\Type\NMTokensValue $parts
     * @param \SimpleSAML\WSDL\Type\UseChoiceValue $use
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $encodingStyle
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $namespace
     */
    final public function __construct(
        protected QNameValue $message,
        protected NMTokensValue $parts,
        UseChoiceValue $use,
        ?AnyURIValue $encodingStyle = null,
        ?AnyURIValue $namespace = null,
    ) {
        // Assertions are handled by the setters
        $this->setEncodingStyle($encodingStyle);
        $this->setUse($use);
        $this->setNamespace($namespace);
    }


    /**
     * Collect the value of the message-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\QNameValue
     */
    public function getMessage(): QNameValue
    {
        return $this->message;
    }


    /**
     * Collect the value of the parts-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NMTokensValue|null
     */
    public function getParts(): ?NMTokensValue
    {
        return $this->parts;
    }


    /**
     * Initialize a Header element.
     *
     * @param \Dom\Element $xml The XML element we should load.
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getAttribute($xml, 'message', QNameValue::class),
            self::getAttribute($xml, 'parts', NMTokensValue::class),
            self::getAttribute($xml, 'use', UseChoiceValue::class),
            self::getOptionalAttribute($xml, 'encodingStyle', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'namespace', AnyURIValue::class),
        );
    }


    /**
     * Convert this tHeader to XML.
     *
     * @param \Dom\Element|null $parent The element we are converting to XML.
     * @return \Dom\Element The XML element after adding the data corresponding to this tHeader
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = $this->instantiateParentElement($parent);

        if (!$e->lookupPrefix($this->getMessage()->getNamespacePrefix()->getValue())) {
            $namespace = new XMLAttribute(
                C::NS_XMLNS,
                'xmlns',
                $this->getMessage()->getNamespacePrefix()->getValue(),
                $this->getMessage()->getNamespaceURI(),
            );
            $namespace->toXML($e);
        }

        $e->setAttribute('message', $this->getMessage()->getValue());
        $e->setAttribute('parts', $this->getParts()->getValue());
        $e->setAttribute('use', $this->getUse()->getValue());

        if ($this->getEncodingStyle() !== null) {
            $e->setAttribute('encodingStyle', $this->getEncodingStyle()->getValue());
        }

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', $this->getNamespace()->getValue());
        }

        return $e;
    }
}
