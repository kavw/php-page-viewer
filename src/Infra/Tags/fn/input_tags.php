<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    literal-string     $name
 * @param    string|\Stringable $value
 * @param    iterable<T>|T      ...$content
 * @return   SingleTag
 */
function text(
    string $name,
    string|\Stringable $value,
    iterable|Attribute|\Stringable|string|null ...$content
): SingleTag {
    $attr = [
        new Attribute('type', 'text'),
        new Attribute('name', $name),
        new Attribute('value', (string) $value),
    ];

    foreach ($content as $i) {
        if ($i instanceof Attribute) {
            $attr[] = $i;
        }
    }

    return new SingleTag('input', ...$attr);
}

/**
 * @template T of Attribute|\Stringable|string|null
 * @param    string        $value
 * @param    iterable<T>|T ...$content
 * @return   SingleTag
 */
function submit(string $value, iterable|Attribute|\Stringable|string|null ...$content): SingleTag
{
    $attr = [
        new Attribute('type', 'submit'),
        new Attribute('value', encode($value))
    ];

    foreach ($content as $i) {
        if ($i instanceof Attribute) {
            $attr[] = $i;
        }
    }

    return new SingleTag('input', ...$attr);
}
