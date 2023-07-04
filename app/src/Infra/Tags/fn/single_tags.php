<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function area(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('area', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function base(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('area', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function br(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('br', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function col(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('col', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function command(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('command', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function embed(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('embed', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function hr(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('hr', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function img(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('img', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function input(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('input', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function keygen(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('keygen', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function link(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('link', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function meta(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('meta', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function param(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('param', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function source(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('source', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function track(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('track', ...$content);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function wbr(iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    return new SingleTag('wbr', ...$content);
}
