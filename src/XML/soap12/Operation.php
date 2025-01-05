<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing the Operation element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Operation extends AbstractOperation implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
