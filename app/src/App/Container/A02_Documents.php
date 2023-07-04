<?php

declare(strict_types=1);

namespace PV\App\Container;

use PV\App\Document\DocumentRepo;
use PV\App\Document\DocumentRepoInterface;
use PV\App\Document\Raw\Db\DocumentDbRepo;
use PV\App\Document\Raw\Fs\DocumentFsRepo;
use PV\App\Document\Search\DummySearchRepo;
use PV\App\Document\Search\SearchRepoInterface;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
abstract  readonly class A02_Documents extends A01_Infra
// phpcs:enable
{
    final public function getDocumentRepo(): DocumentRepoInterface
    {
        static $obj;
        return $obj ?? $obj = new DocumentRepo(
            [
                new DocumentFsRepo($this->settings->pageStorageDir->val),
                new DocumentDbRepo(
                    $this->getConnectionManager()
                )
            ]
        );
    }

    final public function getSearchRepo(): SearchRepoInterface
    {
        return new DummySearchRepo($this->getDocumentRepo());
    }
}
