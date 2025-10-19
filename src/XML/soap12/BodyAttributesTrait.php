<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\WSDL\Type\UseChoiceValue;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * Trait representing the tBodyAttributes group.
 *
 * @package simplesamlphp/xml-wsdl
 */
trait BodyAttributesTrait
{
    /** @var \SimpleSAML\XMLSchema\Type\AnyURIValue|null */
    protected ?AnyURIValue $encodingStyle;

    /** @var \SimpleSAML\WSDL\Type\UseChoiceValue|null */
    protected ?UseChoiceValue $use;

    /** @var \SimpleSAML\XMLSchema\Type\AnyURIValue|null */
    protected ?AnyURIValue $namespace;


    /**
     * Collect the value of the encodingStyle-property
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getEncodingStyle(): ?AnyURIValue
    {
        return $this->encodingStyle;
    }


    /**
     * Set the value of the encodingStyle-property
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $encodingStyle
     */
    protected function setEncodingStyle(?AnyURIValue $encodingStyle = null): void
    {
        $this->encodingStyle = $encodingStyle;
    }


    /**
     * Collect the value of the use-property
     *
     * @return \SimpleSAML\WSDL\Type\UseChoiceValue|null
     */
    public function getUse(): ?UseChoiceValue
    {
        return $this->use;
    }


    /**
     * Set the value of the use-property
     *
     * @param \SimpleSAML\WSDL\Type\UseChoiceValue|null $use
     */
    protected function setUse(?UseChoiceValue $use = null): void
    {
        $this->use = $use;
    }


    /**
     * Collect the value of the namespace-property
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getNamespace(): ?AnyURIValue
    {
        return $this->namespace;
    }


    /**
     * Set the value of the namespace-property
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $namespace
     */
    protected function setNamespace(?AnyURIValue $namespace = null): void
    {
        $this->namespace = $namespace;
    }
}
