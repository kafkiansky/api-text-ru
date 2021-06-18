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
 * @template T of string
 *
 * @template-implements Result<T>
 */
final class Failure implements Result
{
    /**
     * @var T
     */
    private string $error;

    /**
     * @param T $error
     */
    public function __construct(string $error)
    {
        $this->error = $error;
    }

    public function isSucceeded(): bool
    {
        return false;
    }

    public function isFailed(): bool
    {
        return true;
    }

    /**
     * @return T
     */
    public function obtain()
    {
        return $this->error;
    }
}
