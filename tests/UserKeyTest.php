<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\UserKey;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class UserKeyTest extends TestCase
{
    public function testUserKey(): void
    {
        $userKey = new UserKey('12345');
        self::assertEquals('12345', $userKey->value);

        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('User key cannot be an empty string.');
        new UserKey('');
    }
}
