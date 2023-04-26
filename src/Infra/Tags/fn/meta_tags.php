<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @param  string $val
 * @return Tag
 */
function meta_charset(string $val): Tag
{
    return new Tag('meta', new Attribute('charset', $val));
}

/**
 * @param  string $name
 * @param  string $content
 * @return Tag
 */
function meta_name(string $name, string $content): Tag
{
    return new Tag(
        'meta',
        new Attribute('name', $name),
        new Attribute('content', $content)
    );
}

function meta_description(string $description): Tag
{
    return new Tag(
        'meta',
        new Attribute('name', 'description'),
        new Attribute('content', $description)
    );
}

function meta_keywords(string $keywords): Tag
{
    return new Tag(
        'meta',
        new Attribute('name', 'keywords'),
        new Attribute('content', $keywords)
    );
}
