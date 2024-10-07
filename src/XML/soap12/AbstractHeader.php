<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function explode;
use function in_array;

/**
 * Abstract class representing the tHeader type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractHeader extends AbstractExtensibilityElement
{
    use BodyAttributesTrait;

    /** @var string */
    public const NS = C::NS_WSDL_SOAP_12;

    /** @var string */
    public const NS_PREFIX = 'soap12';

    /** @var string */
    public const LOCALNAME = 'header';


    /**
     * Initialize a soap12:body
     *
     * @param string $message
     * @param string $parts
     * @param string $use
     * @param array<\SimpleSAML\WSDL\XML\soap12\HeaderFault> $headerFault
     * @param string|null $encodingStyle
     * @param string|null $namespace
     * @param bool|null $required
     */
    final public function __construct(
        protected string $message,
        protected string $parts,
        string $use,
        protected array $headerFault,
        ?string $encodingStyle = null,
        ?string $namespace = null,
        ?bool $required = null,
    ) {
        Assert::validQName($message, SchemaViolationException::class);
        Assert::allIsInstanceOf($headerFault, HeaderFault::class, SchemaViolationException::class);
        Assert::allRegex(
            // TODO: figure out the right pattern to do this without the explode
            explode(' ', $parts),
            "/^[a-zA-Z0-9._\-:]*$/",
            SchemaViolationException::class,
        ); // xs:NMTOKENS

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
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * Collect the value of the parts-property.
     *
     * @return string|null
     */
    public function getParts(): ?string
    {
        return $this->parts;
    }


    /**
     * Initialize a Header element.
     *
     * @param \DOMElement $xml The XML element we should load.
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $required = null;
        if ($xml->hasAttributeNS(C::NS_WSDL, 'required')) {
            $required = $xml->getAttributeNS(C::NS_WSDL, 'required');
            Assert::oneOf($required, ['0', '1', 'false', 'true'], SchemaViolationException::class);
            $required = in_array($required, ['1', 'true'], true);
        }

        return new static(
            self::getAttribute($xml, 'message'),
            self::getAttribute($xml, 'parts'),
            self::getAttribute($xml, 'use'),
            HeaderFault::getChildrenOfClass($xml),
            self::getOptionalAttribute($xml, 'encodingStyle'),
            self::getOptionalAttribute($xml, 'namespace'),
            $required,
        );
    }


    /**
     * Convert this tHeader to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tHeader
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $e->setAttribute('message', $this->getMessage());
        $e->setAttribute('parts', $this->getParts());
        $e->setAttribute('use', $this->getUse());

        if ($this->getEncodingStyle() !== null) {
            $e->setAttribute('encodingStyle', $this->getEncodingStyle());
        }

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', $this->getNamespace());
        }

        foreach ($this->getHeaderFault() as $headerFault) {
            $headerFault->toXML($e);
        }

        return $e;
    }
}
