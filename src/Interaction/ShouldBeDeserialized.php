<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction;

interface ShouldBeDeserialized
{
    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @throws \InvalidArgumentException
     *
     * @return object
     */
    public static function reconstituteFromArray(array $payload): object;
}
