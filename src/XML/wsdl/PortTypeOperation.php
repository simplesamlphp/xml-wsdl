<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\XML\wsdl;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\NMTokensValue;

/**
 * Class representing the Operation element.
 *
 * @package simplesamlphp/xml-wsdl
 */
final class PortTypeOperation extends AbstractPortTypeOperation
{
    final public const string LOCALNAME = 'operation';


    /**
     * Initialize a Operation element.
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

        $first = null;
        foreach ($xml->childNodes as $element) {
            if (!($element instanceof DOMElement)) {
                continue;
            } elseif ($element->namespaceURI === static::NS) {
                if ($element->localName === 'input') {
                    $first = Input::class;
                    break;
                } elseif ($element->localName === 'output') {
                    $first = Output::class;
                    break;
                }
            }
        }

        Assert::notNull($first, SchemaViolationException::class);

        if ($first === Input::class) {
            // xs:group solicit-response-or-notification-operation
            $input = Input::getChildrenOfClass($xml);
            $input = array_pop($input);
            Assert::notNull($input, SchemaViolationException::class);
            $output = Output::getChildrenOfClass($xml);
            $output = array_pop($output);
        } else {
            // xs:group request-response-or-one-way-operation
            // NOTE:  input is really output and vice versa!!
            $input = Output::getChildrenOfClass($xml);
            $input = array_pop($input);
            Assert::notNull($input, SchemaViolationException::class);
            $output = Input::getChildrenOfClass($xml);
            $output = array_pop($output);
        }

        return new static(
            self::getAttribute($xml, 'name', NCNameValue::class),
            self::getOptionalAttribute($xml, 'parameterOrder', NMTokensValue::class),
            $input,
            $output,
            Fault::getChildrenOfClass($xml),
            self::getChildElementsFromXML($xml),
        );
    }
}
