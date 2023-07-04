<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

class Tag implements \Stringable
{
    /**
     * @var Attribute[]
     */
    protected array $attr = [];

    /**
     * @var array<string|\Stringable>
     */
    protected array $content = [];

    /**
     * @template T of Attribute|\Stringable|string|null
     * @param    string        $name
     * @param    iterable<T>|T ...$content
     */
    public function __construct(
        readonly public string $name,
        iterable|Attribute|\Stringable|string|null ...$content
    ) {
        $stack = [];
        $stack[] = $content;


        while ($collection = array_pop($stack)) {
            if (!is_iterable($collection)) {
                throw new \LogicException("Something went wrong");
            }

            foreach ($collection as $i) {
                if ($i instanceof Attribute) {
                    $this->attr[$i->name] = $i;
                    continue;
                }

                if (is_null($i)) {
                    continue;
                }

                if (is_string($i)) {
                    $this->content[] = encode($i);
                    continue;
                }

                if (is_iterable($i)) {
                    $stack[] = $i;
                    continue;
                }

                $this->content[] = $i;
            }
        }
    }

    public function __toString(): string
    {
        ob_start();

        echo '<', $this->name;
        if ($this->attr) {
            foreach ($this->attr as $attribute) {
                echo ' ', $attribute;
            }
        }
        echo '>';

        foreach ($this->content as $item) {
            echo $item;
        }

        echo '</', $this->name, '>';

        return (string) ob_get_clean();
    }
}
