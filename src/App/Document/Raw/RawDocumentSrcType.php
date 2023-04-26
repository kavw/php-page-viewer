<?php

declare(strict_types=1);

namespace PV\App\Document\Raw;

enum RawDocumentSrcType
{
    case FS;
    case DB;
}
