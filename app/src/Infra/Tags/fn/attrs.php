<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @param  literal-string $name
 * @param  literal-string $val
 * @return Attribute
 */
function attr(string $name, string $val): Attribute
{
    return new Attribute($name, $val);
}

/**
 * @param  literal-string|null ...$values
 * @return Attribute|null
 */
function klass(string|null ...$values): ?Attribute
{
    $data = array_filter(array_map(fn ($i) => trim((string)$i), $values));

    return ($data) ? new Attribute('class', implode(' ', $data)) : null;
}

/**
 * @param  literal-string $val
 * @return Attribute
 */
function id(string $val): Attribute
{
    return new Attribute('id', $val);
}

/**
 * @param  literal-string $val
 * @return Attribute
 */
function src(string $val): Attribute
{
    return new Attribute('src', $val);
}

/**
 * @param  literal-string $val
 * @return Attribute
 */
function alt(string $val): Attribute
{
    return new Attribute('alt', $val);
}

/**
 * @param  literal-string $val
 * @return Attribute
 */
function href(string $val): Attribute
{
    return new Attribute('href', $val);
}

/**
 * @param  int $val
 * @return Attribute
 */
function tabindex(int $val): Attribute
{
    return new Attribute('tabindex', (string) $val);
}

/**
 * @param  literal-string $uri
 * @return Attribute
 */
function action(string $uri): Attribute
{
    return new Attribute('action', $uri);
}

/**
 * @param  literal-string $type
 * @return Attribute
 */
function method(string $type): Attribute
{
    return new Attribute('action', $type);
}

/**
 * @param  string $val
 * @return Attribute
 */
function lang(string $val): Attribute
{
    return new Attribute('lang', $val);
}
