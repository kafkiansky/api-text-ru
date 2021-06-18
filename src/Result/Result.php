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
 * @template T
 */
interface Result
{
    public function isSucceeded(): bool;
    public function isFailed(): bool;

    /**
     * @return T
     */
    public function obtain();
}
