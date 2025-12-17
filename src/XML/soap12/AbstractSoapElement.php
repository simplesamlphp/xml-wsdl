<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\soap12;

use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-wsdl
 */
abstract class AbstractSoapElement extends AbstractElement
{
    public const string NS = C::NS_WSDL_SOAP_12;

    public const string NS_PREFIX = 'soap12';

    public const string SCHEMA = 'resources/schemas/wsdl-soap12.xsd';
}
