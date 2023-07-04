<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

use PV\App\Document\SimplifiedDummyMarkdown\Exceptions\LogicException;

final class BlockFactory implements BlockFactoryInterface
{
    public function __construct(
        /**
         * @var ConcreteFactoryInterface[]
         */
        readonly private array $concreteFactories = [
            new PrimaryHeaderFactory(),
            new SecondaryHeaderFactory(),
            new UnorderedListFactory(),
            new ParagraphFactory(),
        ]
    ) {
    }

    /**
     * @param  string[] $lines
     * @return BlockInterface
     */
    public function create(array $lines): BlockInterface
    {
        if (!$lines) {
            throw new LogicException("There is no sense to create an empty block");
        }

        foreach ($this->concreteFactories as $factory) {
            $block = $factory->test($lines);
            if ($block) {
                return $block;
            }
        }

        throw new LogicException(
            "Looks like default paragraph block factory is omitted"
        );
    }
}
