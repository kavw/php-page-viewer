<?php

declare(strict_types=1);

namespace PV\Infra\Test;

use PHPUnit\Framework\TestCase;
use PV\Infra\Http\Server\Response\Code;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

final class Response
{
    private ?Crawler $crawler = null;

    public function __construct(
        private readonly TestCase $case,
        private readonly SimpleResponseInterface $response
    ) {
    }

    public function getCode(): Code
    {
        return $this->response->getCode();
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    public function getContent(): string
    {
        return $this->response->getContent();
    }

    public function getCrawler(): Crawler
    {
        if ($this->crawler) {
            return $this->crawler;
        }

        return $this->crawler = new Crawler($this->response->getContent());
    }

    public function assertHasCode(
        Code $expected,
        string $message = ''
    ): void {
        $this->case->assertEquals($expected, $this->response->getCode(), $message);
    }

    public function assertHasElement(
        string $selector,
        string $message = ''
    ): void {
        if (!$message) {
            $message = "Response html has element with selector '{$selector}'";
        }

        $crawler = $this->getCrawler();
        $this->case->assertGreaterThan(0, count($crawler->filter($selector)), $message);
    }

    public function assertHasElementWithText(
        string $selector,
        string $text,
        string $message = ''
    ): void {
        if (!$message) {
            $message = "Response html has element with selector '{$selector}' contains '{$text}'";
        }

        $crawler = $this->getCrawler();
        $result  = $crawler->filter($selector);
        $this->case->assertGreaterThan(0, count($result), $message);

        $found = false;
        $result->each(
            function (Crawler $node, $i) use ($text, &$found) {
                if ($node->text() === $text) {
                    $found = true;
                }
            }
        );

        $this->case->assertTrue($found, $message);
    }

    public function assertHasElementWithTextLike(
        string $selector,
        string $text,
        string $message = ''
    ): void {
        if (!$message) {
            $message = "Response html has element with selector '{$selector}' contains like '{$text}'";
        }

        $crawler = $this->getCrawler();
        $result  = $crawler->filter($selector);
        $this->case->assertGreaterThan(0, count($result), $message);

        $found = false;
        $result->each(
            function (Crawler $node, $i) use ($text, &$found) {
                if (str_contains($node->text(), $text)) {
                    $found = true;
                }
            }
        );

        $this->case->assertTrue($found, $message);
    }

    public function assertHasElementWithAttribute(
        string $selector,
        string $attribute,
        string $value,
        string $message = ''
    ): void {
        if (!$message) {
            $message = "Response html has element with selector '{$selector}'" .
                " and attribute '{$attribute}=\"{$value}\"'";
        }

        $crawler = $this->getCrawler();
        $result  = $crawler->filter($selector);
        $this->case->assertGreaterThan(0, count($result), $message);

        $found = false;
        $result->each(
            function (Crawler $node, $i) use ($attribute, $value, &$found) {
                if ($node->attr($attribute) === $value) {
                    $found = true;
                }
            }
        );


        $this->case->assertTrue($found, $message);
    }

    public function assertHasElementWithAttributeAndTextLike(
        string $selector,
        string $attribute,
        string $value,
        string $text,
        string $message = ''
    ): void {
        if (!$message) {
            $message = "Response html has element with selector '{$selector}'" .
                " and attribute '{$attribute}=\"{$value}\"'";
        }

        $crawler = $this->getCrawler();
        $result  = $crawler->filter($selector);
        $this->case->assertGreaterThan(0, count($result), $message);

        $found = false;
        $result->each(
            function (Crawler $node, $i) use ($attribute, $value, $text, &$found) {
                if (
                    $node->attr($attribute) === $value
                    && str_contains($node->text(), $text)
                ) {
                    $found = true;
                }
            }
        );

        $this->case->assertTrue($found, $message);
    }
}
