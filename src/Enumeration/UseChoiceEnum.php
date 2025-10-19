<?php

declare(strict_types=1);

namespace SimpleSAML\WSDL\Enumeration;

enum UseChoiceEnum: string
{
    case Encoded = 'encoded';
    case Literal = 'literal';
}
