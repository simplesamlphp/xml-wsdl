<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\WSDL\XML\wsdl\AbstractExtensibilityElement;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function explode;

/**
 * Abstract class representing the tBody type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBody extends AbstractExtensibilityElement
{
    use BodyAttributesTrait;

    /** @var string */
    public const NS = C::NS_WSDL_SOAP_12;

    /** @var string */
    public const NS_PREFIX = 'soap12';

    /** @var string */
    public const LOCALNAME = 'body';

    /** @var string */
    public const SCHEMA = AbstractSoapElement::SCHEMA;


    /**
     * Initialize a soap12:body
     *
     * @param string|null $parts
     * @param string|null $encodingStyle
     * @param string|null $use
     * @param string|null $namespace
     * @param bool|null $required
     */
    public function __construct(
        protected ?string $parts = null,
        ?string $encodingStyle = null,
        ?string $use = null,
        ?string $namespace = null,
        ?bool $required = null,
    ) {
        if ($parts !== null) {
            Assert::allRegex(
                // TODO: figure out the right pattern to do this without the explode
                explode(' ', $parts),
                "/^[a-zA-Z0-9._\-:]*$/",
                SchemaViolationException::class,
            ); // xs:NMTOKENS
        }

        // Assertions are handled by the setters
        $this->setEncodingStyle($encodingStyle);
        $this->setUse($use);
        $this->setNamespace($namespace);

        parent::__construct($required);
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
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement()
            && empty($this->getParts())
            && empty($this->getEncodingStyle()
            && empty($this->getUse())
            && empty($this->getnamespace()));
    }


    /**
     * Convert this tBody to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBody
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getParts() !== null) {
            $e->setAttribute('parts', $this->getParts());
        }

        if ($this->getEncodingStyle() !== null) {
            $e->setAttribute('encodingStyle', $this->getEncodingStyle());
        }

        if ($this->getUse() !== null) {
            $e->setAttribute('use', $this->getUse());
        }

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', $this->getNamespace());
        }

        return $e;
    }
}
