<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tFault type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractFault extends AbstractExtensibleAttributesDocumented
{
    /**
     * Initialize a wsdl:tFault
     *
     * @param string $name
     * @param string $message
     * @param \SimpleSAML\XML\Attribute[] $attributes
     */
    public function __construct(
        protected string $name,
        protected string $message,
        array $attributes = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::validQName($message, SchemaViolationException::class);

        parent::__construct($attributes);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        // Upstream abstract elements can be empty, but this one cannot
        return false;
    }


    /**
     * Convert this tParam to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tParam.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());
        $e->setAttribute('message', $this->getMessage());

        return $e;
    }
}
