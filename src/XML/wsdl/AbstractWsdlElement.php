<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractWsdlElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_WSDL;

    /** @var string */
    public const NS_PREFIX = 'wsdl';
}
