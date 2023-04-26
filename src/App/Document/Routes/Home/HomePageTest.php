<?php

declare(strict_types=1);

namespace PV\App\Document\Routes\Home;

use PHPUnit\Framework\Attributes\Group;
use PV\Infra\Http\Server\Response\Code;
use PV\Infra\Test\AbstractPageTestCase;

#[Group('page')]
#[Group('functional')]
final class HomePageTest extends AbstractPageTestCase
{
    public function testHomePageSuccess(): void
    {
        $resp = $this->sendRequest('/');
        $resp->assertHasCode(Code::OK);
        $resp->assertHasElementWithText('head > title', 'Welcome!');

        $resp->assertHasElementWithAttributeAndTextLike(
            '.document-list-item > a',
            attribute: 'href',
            value: '/fs/bender.txt',
            text: 'Time Keeps'
        );

        $resp->assertHasElementWithAttributeAndTextLike(
            '.document-list-item > a',
            attribute: 'href',
            value: '/db/denebola',
            text: 'Денебола'
        );
    }

    public function test404Page(): void
    {
        $path = '/' . uniqid('404-');
        $resp = $this->sendRequest($path);
        $resp->assertHasCode(Code::NOT_FOUND);

        $resp->assertHasElementWithText('head > title', 'Welcome!');

        $resp->assertHasElementWithTextLike('.content .message', "'{$path}' not found");
    }
}
