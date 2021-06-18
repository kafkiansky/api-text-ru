<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Result;

/**
 * @template T of object
 *
 * @template-implements Result<T>
 */
final class Success implements Result
{
    /**
     * @var T
     */
    private object $value;

    /**
     * @param T $value
     */
    public function __construct(object $value)
    {
        $this->value = $value;
    }

    public function isSucceeded(): bool
    {
        return true;
    }

    public function isFailed(): bool
    {
        return false;
    }

    /**
     * @return T
     */
    public function obtain()
    {
        return $this->value;
    }
}
