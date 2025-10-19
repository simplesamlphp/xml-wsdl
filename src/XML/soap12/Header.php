<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class representing the Header element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class Header extends AbstractHeader implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
