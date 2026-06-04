<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use Dom;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C_WSDL;
use SimpleSAML\WSDL\Type\RequiredValue;
use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * Abstract class representing the tHeader type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractHeader extends AbstractExtensibilityElement
{
    use BodyAttributesTrait;


    public const string NS = C_WSDL::NS_WSDL_SOAP_12;

    public const string NS_PREFIX = 'soap12';

    public const string LOCALNAME = 'header';

    public const string SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:body
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $message
     * @param \SimpleSAML\XMLSchema\Type\NMTokensValue $parts
     * @param \SimpleSAML\WSDL\Type\UseChoiceValue $use
     * @param array<\SimpleSAML\WSDL\XML\soap12\HeaderFault> $headerFault
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $encodingStyle
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $namespace
     * @param \SimpleSAML\WSDL\Type\RequiredValue|null $required
     */
    final public function __construct(
        protected QNameValue $message,
        protected NMTokensValue $parts,
        UseChoiceValue $use,
        protected array $headerFault,
        ?AnyURIValue $encodingStyle = null,
        ?AnyURIValue $namespace = null,
        ?RequiredValue $required = null,
    ) {
        Assert::allIsInstanceOf($headerFault, HeaderFault::class, SchemaViolationException::class);

        // Assertions are handled by the setters
        $this->setEncodingStyle($encodingStyle);
        $this->setUse($use);
        $this->setNamespace($namespace);

        parent::__construct($required);
    }


    /**
     * Collect the value of the headerFault-property.
     *
     * @return array<\SimpleSAML\WSDL\XML\soap12\HeaderFault>
     */
    public function getHeaderFault(): array
    {
        return $this->headerFault;
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

        $required = null;
        if ($xml->hasAttributeNS(C_WSDL::NS_WSDL, 'required')) {
            $required = RequiredValue::fromString($xml->getAttributeNS(C_WSDL::NS_WSDL, 'required'));
        }

        return new static(
            self::getAttribute($xml, 'message', QNameValue::class),
            self::getAttribute($xml, 'parts', NMTokensValue::class),
            self::getAttribute($xml, 'use', UseChoiceValue::class),
            HeaderFault::getChildrenOfClass($xml),
            self::getOptionalAttribute($xml, 'encodingStyle', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'namespace', AnyURIValue::class),
            $required,
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
        $e = parent::toXML($parent);

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

        foreach ($this->getHeaderFault() as $headerFault) {
            $headerFault->toXML($e);
        }

        return $e;
    }
}
