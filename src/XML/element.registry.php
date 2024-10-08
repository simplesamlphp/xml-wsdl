<?php

declare(strict_types=1);

return [
    'http://schemas.xmlsoap.org/wsdl/' => [
        'definitions' => '\SimpleSAML\WSSecurity\XML\wsdl\Definitions',
    ],
    'http://schemas.xmlsoap.org/wsdl/soap12' => [
        'address' => '\SimpleSAML\WSSecurity\XML\soap12\Address',
        'binding' => '\SimpleSAML\WSSecurity\XML\soap12\Binding',
        'body' => '\SimpleSAML\WSSecurity\XML\soap12\Body',
        'fault' => '\SimpleSAML\WSSecurity\XML\soap12\Fault',
        'header' => '\SimpleSAML\WSSecurity\XML\soap12\Header',
        'headerfault' => '\SimpleSAML\WSSecurity\XML\soap12\HeaderFault',
        'operation' => '\SimpleSAML\WSSecurity\XML\soap12\Operation',
    ],
];
