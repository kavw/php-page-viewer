<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Response;

enum Code: int
{
    case OK = 200;
    case NOT_FOUND = 404;
}
