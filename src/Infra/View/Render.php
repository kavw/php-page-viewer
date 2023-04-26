<?php

declare(strict_types=1);

namespace PV\Infra\View;

final readonly class Render implements RenderInterface
{
    public function __construct(
        private RendererFactoryInterface $rendererFactory
    ) {
    }

    /**
     * @param AbstractView $view
     * @return string
     * @throws \Throwable
     */
    public function __invoke(AbstractView $view): string
    {
        return $this->rendererFactory->create($view)->render();
    }
}
