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
    /** @var string */
    public const SCHEMA_TYPE = 'tUseChoice';


    /**
     * Validate the value.
     *
     * @param string $value  The value
     * @throws \Exception on failure
     * @return void
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
     * @return static
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
