<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Utils;

use DOMNode;
use DOMXPath;
use SimpleSAML\WSDL\Constants as C;
use SimpleSAML\XPath\XPath as XPathUtils;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/xml-wsdl
 */
class XPath extends XPathUtils
{
    /**
     * Get a DOMXPath object that can be used to search for XMLDSIG elements.
     *
     * @param \DOMNode $node The document to associate to the DOMXPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \DOMXPath A DOMXPath object ready to use in the given document, with the XMLDSIG namespace already
     * registered.
     */
    public static function getXPath(DOMNode $node, bool $autoregister = false): DOMXPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('wsdl', C::NS_WSDL);
        $xp->registerNamespace('wsdl_soap11', C::NS_WSDL_SOAP_11);
        $xp->registerNamespace('wsdl_soap12', C::NS_WSDL_SOAP_12);

        return $xp;
    }
}
