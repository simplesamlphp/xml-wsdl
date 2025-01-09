<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function array_map;

/**
 * Abstract class representing the tMessage type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractMessage extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tMessage
     *
     * @param string $name
     * @param \SimpleSAML\WSDL\XML\wsdl\Part[] $parts
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        protected array $parts,
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::allIsInstanceOf($parts, Part::class, SchemaViolationException::class);

        $partNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $parts,
        );
        Assert::uniqueValues($partNames, "Part-elements must have unique names.", SchemaViolationException::class);

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
     * Collect the value of the parts-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Part[]
     */
    public function getParts(): array
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

        foreach ($this->getParts() as $part) {
            $part->toXML($e);
        }

        return $e;
    }
}
