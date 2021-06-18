<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Account;

use Kafkiansky\TextRu\Api\Interaction\ShouldBeDeserialized;

/**
 * @psalm-immutable
 */
final class Size implements ShouldBeDeserialized
{
    public function __construct(public int $value)
    {
    }

    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @return Size
     */
    public static function reconstituteFromArray(array $payload): Size
    {
        if (isset($payload['size'])) {
            return new Size((int) $payload['size']);
        }

        throw new \InvalidArgumentException('Size field expected, but not found.');
    }
}
