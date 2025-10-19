<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;

use function array_map;

/**
 * Abstract class representing the tDefinitions type.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractDefinitions extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tDefinitions
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $targetNamespace
     * @param \SimpleSAML\XMLSchema\Type\NCNameValue|null $name
     * @param \SimpleSAML\WSDL\XML\wsdl\Import[] $import
     * @param \SimpleSAML\WSDL\XML\wsdl\Types[] $types
     * @param \SimpleSAML\WSDL\XML\wsdl\Message[] $message
     * @param \SimpleSAML\WSDL\XML\wsdl\PortType[] $portType
     * @param \SimpleSAML\WSDL\XML\wsdl\Binding[] $binding
     * @param \SimpleSAML\WSDL\XML\wsdl\Service[] $service
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected ?AnyURIValue $targetNamespace = null,
        protected ?NCNameValue $name = null,
        protected array $import = [],
        protected array $types = [],
        protected array $message = [],
        protected array $portType = [],
        protected array $binding = [],
        protected array $service = [],
        array $elements = [],
    ) {
        Assert::allIsInstanceOf($import, Import::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($types, Types::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($message, Message::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($portType, PortType::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($binding, Binding::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($service, Service::class, SchemaViolationException::class);

        $messageNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $message,
        );
        Assert::uniqueValues(
            $messageNames,
            "Message-elements must have unique names.",
            SchemaViolationException::class,
        );

        $portTypeNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $portType,
        );
        Assert::uniqueValues(
            $portTypeNames,
            "PortType-elements must have unique names.",
            SchemaViolationException::class,
        );

        $bindingNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $binding,
        );
        Assert::uniqueValues(
            $bindingNames,
            "Binding-elements must have unique names.",
            SchemaViolationException::class,
        );

        $serviceNames = array_map(
            function ($x) {
                return $x->getName();
            },
            $service,
        );
        Assert::uniqueValues(
            $serviceNames,
            "Service-elements must have unique names.",
            SchemaViolationException::class,
        );

        $importNamespaces = array_map(
            function ($x) {
                return $x->getNamespace();
            },
            $import,
        );
        Assert::uniqueValues(
            $importNamespaces,
            "Import-elements must have unique namespaces.",
            SchemaViolationException::class,
        );

        parent::__construct($elements);
    }


    /**
     * Collect the value of the name-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\NCNameValue|null
     */
    public function getName(): ?NCNameValue
    {
        return $this->name;
    }


    /**
     * Collect the value of the targetNamespace-property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getTargetNamespace(): ?AnyURIValue
    {
        return $this->targetNamespace;
    }


    /**
     * Collect the value of the import-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Import[]
     */
    public function getImport(): array
    {
        return $this->import;
    }


    /**
     * Collect the value of the typrd-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Types[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }


    /**
     * Collect the value of the message-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Message[]
     */
    public function getMessage(): array
    {
        return $this->message;
    }


    /**
     * Collect the value of the portType-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\PortType[]
     */
    public function getPortType(): array
    {
        return $this->portType;
    }


    /**
     * Collect the value of the binding-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Binding[]
     */
    public function getBinding(): array
    {
        return $this->binding;
    }


    /**
     * Collect the value of the service-property.
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Service[]
     */
    public function getService(): array
    {
        return $this->service;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getName()) &&
            empty($this->getTargetNamespace()) &&
            empty($this->getImport()) &&
            empty($this->getTypes()) &&
            empty($this->getMessage()) &&
            empty($this->getPortType()) &&
            empty($this->getBinding()) &&
            empty($this->getService());
    }


    /**
     * Convert this tDefinitions to XML.
     *
     * @param \DOMElement|null $parent The element we are converting to XML.
     * @return \DOMElement The XML element after adding the data corresponding to this tDefinitions.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getTargetNamespace() !== null) {
            $e->setAttribute('targetNamespace', $this->getTargetNamespace()->getValue());
        }

        if ($this->getName() !== null) {
            $e->setAttribute('name', $this->getName()->getValue());
        }

        foreach ($this->getImport() as $import) {
            $import->toXML($e);
        }

        foreach ($this->getTypes() as $types) {
            $types->toXML($e);
        }

        foreach ($this->getMessage() as $message) {
            $message->toXML($e);
        }

        foreach ($this->getPortType() as $portType) {
            $portType->toXML($e);
        }

        foreach ($this->getBinding() as $binding) {
            $binding->toXML($e);
        }

        foreach ($this->getService() as $service) {
            $service->toXML($e);
        }

        return $e;
    }
}
