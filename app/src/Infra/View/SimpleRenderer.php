<?php

declare(strict_types=1);

namespace PV\Infra\View;

use PV\Infra\Http\Server\Router\RouterInterface;
use PV\Infra\WebResource\WebResourceManagerInterface;

final class SimpleRenderer implements SimpleRendererInterface
{
    private const CONTENT_SLOT = '';

    private int $obCnt = 0;
    private ?string $slot = null;
    private ?ViewInterface $layout = null;

    public function __construct(
        readonly private ViewInterface $view,
        readonly private string $projRoot,
        readonly private RouterInterface $router,
        readonly private WebResourceManagerInterface $resourceManager,
        /**
         * @var array<string, string>
         */
        private array $slots = [],
    ) {
    }

    public function layout(ViewInterface $view): void
    {
        $this->layout = $view;
    }

    /**
     * @param non-empty-string $slotName
     * @return void
     */
    public function begin(string $slotName): void
    {
        if ($this->slot) {
            throw new \LogicException(
                "The slot '{$this->slot}' has been started already"
            );
        }

        $this->slot = $this->filterSlotName($slotName);
        $this->obStart();
    }

    public function end(): void
    {
        if ($this->slot === null) {
            throw new \LogicException(
                "There is no an opened slot"
            );
        }

        if (!isset($this->slots[$this->slot])) {
            $this->slots[$this->slot]  = $this->obGetClean();
        } else {
            $this->slots[$this->slot] .= $this->obGetClean();
        }

        $this->slot = null;
    }

    public function content(): string
    {
        if (!isset($this->slots[self::CONTENT_SLOT])) {
            throw new \LogicException(
                "The content hasn't been rendered"
            );
        }

        return $this->slots[self::CONTENT_SLOT];
    }

    public function slot(string $name, string $default = ''): string
    {
        return $this->slots[$this->filterSlotName($name)] ?? $default;
    }

    public function render(): string
    {
        $this->obStart();
        try {
            include $this->resolvePath();
            $this->slots[self::CONTENT_SLOT] = $this->obGetClean();
        } catch (\Throwable $e) {
            $this->obGetClean();
            throw $e;
        }

        if ($this->layout === null) {
            return $this->slots[self::CONTENT_SLOT];
        }

        return (new self(
            $this->layout,
            $this->projRoot,
            $this->router,
            $this->resourceManager,
            $this->slots
        ))->render();
    }

    /**
     * @param ViewInterface $view
     * @return string
     * @throws \Throwable
     */
    public function include(ViewInterface $view): string
    {
        $obj = new self(
            $view,
            $this->projRoot,
            $this->router,
            $this->resourceManager,
            $this->slots,
        );

        try {
            return ($obj)->render();
        } finally {
            foreach ($obj->slots as $k => $v) {
                if ($k == self::CONTENT_SLOT) {
                    continue;
                }
                if (!isset($this->slots[$k])) {
                    $this->slots[$k]  = $v;
                } else {
                    $this->slots[$k] .= $v;
                }
            }
        }
    }

    public function link(string $name, array $params = []): string
    {
        return $this->router->link($name, $params);
    }

    public function media(string $path): string
    {
        return $this->resourceManager->media($path);
    }

    private function filterSlotName(string $value): string
    {
        $name = trim($value);
        if (!$name) {
            throw new \InvalidArgumentException(
                "The \$slotName argument must be a non empty string"
            );
        }
        return self::CONTENT_SLOT . $name;
    }

    private function resolvePath(): string
    {
        $path = $this->view->getTemplatePath();
        if (str_starts_with($path, '/')) {
            return $path;
        }

        return $this->projRoot . '/' . $path;
    }

    private function obStart(): void
    {
        ob_start();
        $this->obCnt++;
    }

    public function obGetClean(): string
    {
        try {
            return (string) ob_get_clean();
        } finally {
            $this->obCnt--;
        }
    }
}
