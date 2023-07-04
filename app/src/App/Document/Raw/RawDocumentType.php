<?php

declare(strict_types=1);

namespace PV\App\Document\Raw;

enum RawDocumentType
{
    case TEXT;
    case HTML;
    case UNKNOWN;
}
