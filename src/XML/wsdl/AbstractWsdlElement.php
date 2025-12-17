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
    public const string NS = C::NS_WSDL;

    public const string NS_PREFIX = 'wsdl';

    public const string SCHEMA = 'resources/schemas/wsdl.xsd';
}
