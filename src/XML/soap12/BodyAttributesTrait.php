<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Trait representing the tBodyAttributes group.
 *
 * @package simplesamlphp/xml-wsdl
 */
trait BodyAttributesTrait
{
    /** @var string|null */
    protected ?string $encodingStyle;

    /** @var string|null */
    protected ?string $use;

    /** @var string|null */
    protected ?string $namespace;


    /**
     * Collect the value of the encodingStyle-property
     *
     * @return string|null
     */
    public function getEncodingStyle(): ?string
    {
        return $this->encodingStyle;
    }


    /**
     * Set the value of the encodingStyle-property
     *
     * @param string|null $encodingStyle
     */
    protected function setEncodingStyle(?string $encodingStyle = null): void
    {
        Assert::nullOrValidURI($encodingStyle, SchemaViolationException::class);
        $this->encodingStyle = $encodingStyle;
    }


    /**
     * Collect the value of the use-property
     *
     * @return string|null
     */
    public function getUse(): ?string
    {
        return $this->use;
    }


    /**
     * Set the value of the use-property
     *
     * @param string|null $use
     */
    protected function setUse(?string $use = null): void
    {
        Assert::nullOrOneOf($use, ['literal', 'encoded'], SchemaViolationException::class);
        $this->use = $use;
    }


    /**
     * Collect the value of the namespace-property
     *
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }


    /**
     * Set the value of the namespace-property
     *
     * @param string|null $namespace
     */
    protected function setNamespace(?string $namespace = null): void
    {
        Assert::nullOrValidURI($namespace, SchemaViolationException::class);
        $this->namespace = $namespace;
    }
}
