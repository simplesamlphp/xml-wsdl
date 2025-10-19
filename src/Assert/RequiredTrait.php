<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Assert;

/**
 * @package simplesamlphp/xml-wsdl
 */
trait RequiredTrait
{
    /**
     * @param string $value
     * @param string $message
     */
    protected static function validRequired(string $value, string $message = ''): void
    {
        parent::validBoolean($value, $message);
    }
}
