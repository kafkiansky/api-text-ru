<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Verification;

use Kafkiansky\TextRu\Api\TextruMethod;

/**
 * @template T of TextVerificationResult
 *
 * @template-extends TextruMethod<T>
 */
final class GetTextVerificationResult extends TextruMethod
{
    private string $uid;
    private ?string $jsonVisible = null;

    public function __construct(string $uid, bool $detail = true)
    {
        if ('' === $uid) {
           throw new \InvalidArgumentException('Uid cannot be an empty string.');
        }

        $this->uid = $uid;
        $this->jsonVisible = $detail ? 'detail' : null;
    }

    public function path(): string
    {
        return 'post';
    }

    public function serializeTo(): string
    {
        return TextVerificationResult::class;
    }

    public function payload(): array
    {
        return array_filter([
            'uid' => $this->uid,
            'jsonvisible' => $this->jsonVisible,
        ]);
    }
}
