<?php

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Text\CheckText;
use Kafkiansky\TextRu\Api\Tests\Tools\FakeHttpClient;

final class CheckTextTest extends InteractionTestCase
{
    public function testTextQueued(): void
    {
        $provider = $this->createInteractionProvider(file_get_contents(__DIR__ . '/stubs/text_queued.json'));

        $result = $provider->call(
            CheckText::new('Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum.')
        );

        self::assertTrue($result->isSucceeded());
        self::assertEquals('6234sfd5623462', $result->obtain()->uid);

        $currentResponse = FakeHttpClient::$lastPayload;

        self::assertCount(2, $currentResponse);
        self::assertEquals('test', $currentResponse['userkey']);
        self::assertEquals(
            'Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum.',
            $currentResponse['text']
        );

        $result = $provider->call(
            CheckText::new('Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum.')
                ->exceptDomain(['ru', 'de'])
                ->exceptUrl(['https://google.com', 'https://facebook.com'])
                ->shouldBeVisible()
                ->mustNotBeCopying()
                ->withCallback('https://api.test.ru/text-ru/callback')
        );

        self::assertTrue($result->isSucceeded());
        self::assertEquals('6234sfd5623462', $result->obtain()->uid);

        $currentResponse = FakeHttpClient::$lastPayload;

        self::assertCount(7, $currentResponse);
        self::assertEquals('test', $currentResponse['userkey']);
        self::assertEquals(
            'Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum.',
            $currentResponse['text']
        );
        self::assertEquals('vis_on', $currentResponse['visible']);
        self::assertEquals('noadd', $currentResponse['copying']);
        self::assertEquals('https://api.test.ru/text-ru/callback', $currentResponse['callback']);
        self::assertEquals('ru,de', $currentResponse['exceptdomain']);
        self::assertEquals('https://google.com,https://facebook.com', $currentResponse['excepturl']);
    }
}
