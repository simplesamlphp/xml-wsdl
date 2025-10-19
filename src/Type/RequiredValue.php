<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Type;

use SimpleSAML\WSDL\Assert\Assert;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\Interface\AttributeTypeInterface;

/**
 * @package simplesaml/xml-wsdl
 */
class RequiredValue extends BooleanValue implements AttributeTypeInterface
{
    /** @var string */
    public const SCHEMA_TYPE = 'boolean';


    /**
     * Validate the value.
     *
     * @param string $value
     * @throws \SimpleSAML\XMLSchema\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateValue(string $value): void
    {
        // Note: value must already be sanitized before validating
        Assert::validRequired($this->sanitizeValue($value), SchemaViolationException::class);
    }


    /**
     * Convert this value to an attribute
     *
     * @return \SimpleSAML\XML\Attribute
     */
    public function toAttribute(): Attribute
    {
        return new Attribute(C::NS_WSDL, 'wsdl', 'required', $this);
    }
}
