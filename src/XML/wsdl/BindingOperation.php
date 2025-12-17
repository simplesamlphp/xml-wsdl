<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\NCNameValue;

use function array_pop;

/**
 * Class representing the BindingOperation element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class BindingOperation extends AbstractBindingOperation
{
    final public const string LOCALNAME = 'operation';


    /**
     * Initialize a BindingOperation element.
     *
     * @param \DOMElement $xml The XML element we should load.
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::LOCALNAME, InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $input = BindingOperationInput::getChildrenOfClass($xml);
        $output = BindingOperationOutput::getChildrenOfClass($xml);
        $faults = BindingOperationFault::getChildrenOfClass($xml);

        return new static(
            self::getAttribute($xml, 'name', NCNameValue::class),
            array_pop($input),
            array_pop($output),
            $faults,
            self::getChildElementsFromXML($xml),
        );
    }
}
