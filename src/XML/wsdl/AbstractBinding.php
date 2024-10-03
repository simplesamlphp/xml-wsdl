<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Abstract class representing the tBinding type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractBinding extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tBinding
     *
     * @param string $name
     * @param string $type
     * @param \SimpleSAML\WSDL\XML\wsdl\BindingOperation[] $operation
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        protected string $type,
        protected array $operation = [],
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::validQName($type, SchemaViolationException::class);
        Assert::allIsInstanceOf($operation, BindingOperation::class, SchemaViolationException::class);

        parent::__construct($elements);
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
     * Collect the value of the type-property.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * Collect the value of the operation-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\BindingOperation[]
     */
    public function getOperation(): array
    {
        return $this->operation;
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
     * Convert this tBinding to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tBinding.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());
        $e->setAttribute('type', $this->getType());

        foreach ($this->getOperation() as $operation) {
            $operation->toXML($e);
        }

        return $e;
    }
}
