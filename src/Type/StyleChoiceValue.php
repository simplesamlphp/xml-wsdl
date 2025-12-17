<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Type;

use SimpleSAML\Assert\Assert;
use SimpleSAML\WSDL\Enumeration\StyleChoiceEnum;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\StringValue;

use function array_column;

/**
 * @package simplesamlphp/xml-wsdl
 */
class StyleChoiceValue extends StringValue
{
    public const string SCHEMA_TYPE = 'tStyleChoice';


    /**
     * Validate the value.
     *
     * @throws \Exception on failure
     */
    protected function validateValue(string $value): void
    {
        Assert::oneOf(
            $this->sanitizeValue($value),
            array_column(StyleChoiceEnum::cases(), 'value'),
            SchemaViolationException::class,
        );
    }


    /**
     * @param \SimpleSAML\WSDL\Enumeration\StyleChoiceEnum $value
     */
    public static function fromEnum(StyleChoiceEnum $value): static
    {
        return new static($value->value);
    }


    /**
     * @return \SimpleSAML\WSDL\Enumeration\StyleChoiceEnum $value
     */
    public function toEnum(): StyleChoiceEnum
    {
        return StyleChoiceEnum::from($this->getValue());
    }
}
