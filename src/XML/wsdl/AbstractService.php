<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function array_map;

/**
 * Abstract class representing the tService type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractService extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tService
     *
     * @param string $name
     * @param \SimpleSAML\WSDL\XML\wsdl\Port[] $ports
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        protected array $ports,
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        Assert::allIsInstanceOf($ports, Port::class, SchemaViolationException::class);

        $portNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $ports,
        );
        Assert::uniqueValues($portNames, "Port-elements must have unique names.", SchemaViolationException::class);

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
     * Collect the value of the ports-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Port[]
     */
    public function getPorts(): array
    {
        return $this->ports;
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
     * Convert this tService to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tService.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', $this->getName());

        foreach ($this->getPorts() as $port) {
            $port->toXML($e);
        }

        return $e;
    }
}
