<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\InteractionsProvider;
use Kafkiansky\TextRu\Api\Tests\Tools\FakeHttpClient;
use Kafkiansky\TextRu\Api\UserKey;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
abstract class InteractionTestCase extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        FakeHttpClient::flush();
    }

    final public function createInteractionProvider(string $response, int $code = 200): InteractionsProvider
    {
        return new InteractionsProvider(
            new UserKey('test'),
            new FakeHttpClient($response, $code)
        );
    }
}
