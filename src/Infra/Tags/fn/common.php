<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

function encode(
    string|\Stringable $content,
    bool $doubleEncode = true
): string {
    return htmlspecialchars(
        (string)$content,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8',
        $doubleEncode
    );
}

/**
 * @template T
 * @template R of string|\Stringable|null
 * @template X of iterable<R>|string|\Stringable|null
 * @param    iterable<T>                         $items
 * @param    callable(LoopCtx<T>): X             $cb
 * @param    string|\Stringable|iterable<R>|null $else
 * @return   \Generator<string|\Stringable|iterable<R>|null>
 */
function loop(
    iterable $items,
    callable $cb,
    string|\Stringable|null|iterable $else
): iterable {
    $i = 0;
    $prev = null;
    foreach ($items as $item) {
        if ($i === 0) {
            $prev = $item;
            $i++;
            continue;
        }

        if ($prev) {
            /**
 * @var T $prev
*/
            yield $cb(new LoopCtx($prev, $i - 1, false));
            $prev = $item;
            $i++;
        }
    }

    if ($prev) {
        /**
 * @var T $prev
*/
        yield $cb(new LoopCtx($prev, $i - 1, true));
        return;
    }

    yield $else;
}

/**
 * @template T of string|\Stringable|null
 * @param    bool          $cond
 * @param    T|iterable<T> $content
 * @param    T|iterable<T> $else
 * @return   T|iterable<T>
 */
function test(
    bool $cond,
    string|\Stringable|iterable|null $content,
    string|\Stringable|iterable|null $else = null
): string|\Stringable|iterable|null {
    return $cond ? $content : $else;
}

function raw(string $value): Raw
{
    return new Raw($value);
}
