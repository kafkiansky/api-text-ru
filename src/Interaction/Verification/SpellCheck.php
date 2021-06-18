<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Verification;

/**
 * @psalm-immutable
 */
final class SpellCheck
{
    public function __construct(public array $checks = [])
    {
    }

    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @return SpellCheck
     */
    public static function fromArray(array $payload): SpellCheck
    {
        $checks = isset($payload['spell_check']) && '' !== $payload['spell_check'] ? $payload['spell_check'] : [];

        if (is_string($checks)) {
            /** @var array */
            $checks = json_decode($checks, true);

            if (JSON_ERROR_NONE !== json_last_error()) {
                $checks = [];
            }
        }

        /** @var array $checks */
        return new SpellCheck($checks);
    }
}
