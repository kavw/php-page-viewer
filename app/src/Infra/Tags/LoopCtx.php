<?php

//phpcs:disable PSR12.Files.FileHeader
declare(strict_types=1);

namespace PV\Infra\Tags;

/**
 * @template T
 */
readonly final class LoopCtx
{
    /**
     * @param T    $item
     * @param int  $i
     * @param bool $last
     */
    public function __construct(
        public mixed $item,
        public int $i,
        public bool $last,
    ) {
    }
}
//phpcs:enable
