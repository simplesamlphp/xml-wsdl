<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing the Binding element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Binding extends AbstractBinding implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
