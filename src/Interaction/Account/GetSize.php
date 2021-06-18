<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Account;

use Kafkiansky\TextRu\Api\TextruMethod;

/**
 * @template T of Size
 *
 * @template-extends TextruMethod<T>
 */
final class GetSize extends TextruMethod
{
    public function path(): string
    {
        return 'account';
    }

    public function serializeTo(): string
    {
        return Size::class;
    }

    public function payload(): array
    {
        return [
            'method' => 'get_packages_info',
        ];
    }
}
