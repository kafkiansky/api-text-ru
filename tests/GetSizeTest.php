<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Account\GetSize;

final class GetSizeTest extends InteractionTestCase
{
    public function testThatErrorOccurredWhenGetSizeRequested(): void
    {
        $provider = $this->createInteractionProvider(
            file_get_contents(__DIR__ . '/stubs/invalid_user_key.json')
        );

        $result = $provider->call(new GetSize());
        self::assertTrue($result->isFailed());
        self::assertEquals('Несуществующий пользовательский ключ', $result->obtain());
    }

    public function testSizeEvaluated(): void
    {
        $provider = $this->createInteractionProvider(
            file_get_contents(__DIR__ . '/stubs/get_size.json')
        );

        $result = $provider->call(new GetSize());
        self::assertTrue($result->isSucceeded());
        self::assertEquals(300000, $result->obtain()->value);
    }
}
