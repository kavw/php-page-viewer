<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    literal-string $name
 * @param    iterable<T>|T  ...$content
 * @return   Tag
 */
function tag(string $name, iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag($name, ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   HtmlTag
 */
function html(iterable|Attribute|\Stringable|string|null ...$content): HtmlTag
{
    return new HtmlTag('html', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function head(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('head', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function body(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('body', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function title(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('title', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function header(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('header', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function main(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('main', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function footer(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('footer', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function aside(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('aside', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function article(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('article', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function div(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('div', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function p(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('p', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function ul(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('ul', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function li(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('li', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function span(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('span', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function a(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('a', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function small(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('small', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   Tag
 */
function form(iterable|Attribute|\Stringable|string|null ...$content): Tag
{
    return new Tag('form', ...$content);
}
