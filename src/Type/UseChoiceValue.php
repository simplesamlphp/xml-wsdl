<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Enumeration\UseChoiceEnum;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\StringValue;

use function array_column;

/**
 * @package simplesamlphp/xml-wsdl
 */
class UseChoiceValue extends StringValue
{
    public const string SCHEMA_TYPE = 'tUseChoice';


    /**
     * Validate the value.
     *
     * @throws \Exception on failure
     */
    protected function validateValue(string $value): void
    {
        Assert::oneOf(
            $this->sanitizeValue($value),
            array_column(UseChoiceEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\WSDL\Enumeration\UseChoiceEnum $value
     */
    public static function fromEnum(UseChoiceEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\WSDL\Enumeration\UseChoiceEnum $value
     */
    public function toEnum(): UseChoiceEnum
    {
        return UseChoiceEnum::from($this->getValue());
    }
}
