<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class representing the Fault element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Fault extends AbstractFault implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
