<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function explode;

/**
 * Abstract class representing the tHeaderFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractHeaderFault extends AbstractSoapElement
{
    use BodyAttributesTrait;

    /** @var string */
    public const LOCALNAME = 'headerfault';


    /**
     * Initialize a soap12:body
     *
     * @param string $message
     * @param string $parts
     * @param string $use
     * @param string|null $encodingStyle
     * @param string|null $namespace
     */
    final public function __construct(
        protected string $message,
        protected string $parts,
        string $use,
        ?string $encodingStyle = null,
        ?string $namespace = null,
    ) {
        Assert::validQName($message, SchemaViolationException::class);
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

        return new static(
            self::getAttribute($xml, 'message'),
            self::getAttribute($xml, 'parts'),
            self::getAttribute($xml, 'use'),
            self::getOptionalAttribute($xml, 'encodingStyle'),
            self::getOptionalAttribute($xml, 'namespace'),
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

        return $e;
    }
}
