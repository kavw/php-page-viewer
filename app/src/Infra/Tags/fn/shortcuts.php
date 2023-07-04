<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

function css(string $href, string $media = 'screen'): Tag
{
    return new Tag(
        'link',
        new Attribute('href', $href),
        new Attribute('media', $media),
        new Attribute('rel', 'stylesheet'),
        new Attribute('type', 'text/css'),
    );
}
