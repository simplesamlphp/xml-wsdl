<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL;

/**
 * Class holding constants relevant for WSDL.
 *
 * @package simplesamlphp/xml-wsdl
 */

class Constants extends \SimpleSAML\XML\Constants
{
    /**
     * The namespace for the Web Service Description Language protocol.
     */
    public const NS_WSDL = 'http://schemas.xmlsoap.org/wsdl/';

    /**
     * The namespace for SOAP 1.1 WSDL
     */
    public const NS_WSDL_SOAP_11 = 'http://schemas.xmlsoap.org/wsdl/soap/';

    /**
     * The namespace for SOAP 1.2 WSDL
     */
    public const NS_WSDL_SOAP_12 = 'http://schemas.xmlsoap.org/wsdl/soap12/';
}
