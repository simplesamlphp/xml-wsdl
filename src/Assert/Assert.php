<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Assert;

use SimpleSAML\XML\Assert\Assert as BaseAssert;

/**
 * SimpleSAML\WSDL\Assert\Assert wrapper class
 *
 * @package simplesamlphp/xml-wsdl
 *
 * @method static void validRequired(mixed $value, string $message = '', string $exception = '')
 * @method static void nullOrValidRequired(mixed $value, string $message = '', string $exception = '')
 * @method static void allValidRequired(mixed $value, string $message = '', string $exception = '')
 */
class Assert extends BaseAssert
{
    use RequiredTrait;
}
