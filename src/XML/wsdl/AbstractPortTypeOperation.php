<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function explode;

/**
 * Abstract class representing the operation-element.
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractPortTypeOperation extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tOperation
     *
     * @param string $name
     * @param string|null $parameterOrder
     * @param \SimpleSAML\WSDL\XML\wsdl\Input|null $input
     * @param \SimpleSAML\WSDL\XML\wsdl\Output|null $output
     * @param \SimpleSAML\WSDL\XML\wsdl\Fault[] $fault
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        protected string $name,
        protected ?string $parameterOrder = null,
        protected ?AbstractParam $input = null,
        protected ?AbstractParam $output = null,
        protected array $fault = [],
        array $elements = [],
    ) {
        Assert::validNCName($name, SchemaViolationException::class);
        if ($parameterOrder !== null) {
            Assert::allRegex(
                // TODO: figure out the right pattern to do this without the explode
                explode(' ', $parameterOrder),
                "/^[a-zA-Z0-9._\-:]*$/",
                SchemaViolationException::class,
            ); // xs:NMTOKENS
        }
        Assert::allIsInstanceOf($fault, Fault::class, SchemaViolationException::class);

        parent::__construct($elements);
    }


    /**
     * Collect the value of the name-property
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Collect the value of the parameterOrder-property
     *
     * @return string|null
     */
    public function getParameterOrder(): ?string
    {
        return $this->parameterOrder;
    }


    /**
     * Collect the value of the input-property
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\AbstractParam|null
     */
    public function getInput(): ?AbstractParam
    {
        return $this->input;
    }


    /**
     * Collect the value of the output-property
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\AbstractParam|null
     */
    public function getOutput(): ?AbstractParam
    {
        return $this->output;
    }


    /**
     * Collect the value of the fault-property
     *
     * @return \SimpleSAML\WSDL\XML\wsdl\Fault[]
     */
    public function getFault(): array
    {
        return $this->fault;
    }


    /**
     * Convert this RequestResponseOrOneWayOperation to XML.
     *
     * @param \DOMElement|null $parent The element we should add this organization to.
     * @return \DOMElement This Organization-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('name', $this->getName());

        if ($this->getParameterOrder() !== null) {
            $e->setAttribute('parameterOrder', $this->getParameterOrder());
        }

        $this->getInput()?->toXML($e);
        $this->getOutput()?->toXML($e);

        foreach ($this->getFault() as $fault) {
            $fault->toXML($e);
        }

        return $e;
    }
}
