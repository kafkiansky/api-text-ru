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
final class SeoCheck
{
    public function __construct(
        public ?int $countCharsWithSpace = null,
        public ?int $countCharsWithoutSpace = null,
        public ?int $countWords = null,
        public ?int $waterPercent = null,
        public ?int $spamPercent = null,
        public array $listKeys = [],
        public array $listKeysGroup = [],
        public array $mixedWords = [],
    ) {
    }

    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @return SeoCheck
     */
    public static function fromArray(array $payload): SeoCheck
    {
        $checks = isset($payload['seo_check']) && '' !== $payload['seo_check'] ? $payload['seo_check'] : [];

        if (is_string($checks)) {
            /** @var array{
             *      count_chars_with_space?: int,
             *      count_chars_without_space?: int,
             *      count_words?: int,
             *      water_percent?: int,
             *      spam_percent?: int,
             *      mixed_words?: array<array-key, mixed>,
             *      list_keys?: array<array-key, mixed>,
             *      list_keys_group?: array<array-key, mixed>,
             * }
             */
            $checks = json_decode($checks, true);

            if (JSON_ERROR_NONE === json_last_error()) {
                return new SeoCheck(
                    $checks['count_chars_with_space'] ?? null,
                    $checks['count_chars_without_space'] ?? null,
                    $checks['count_words'] ?? null,
                    $checks['water_percent'] ?? null,
                    $checks['spam_percent'] ?? null,
                    $checks['mixed_words'] ?? [],
                    $checks['list_keys'] ?? [],
                    $checks['list_keys_group'] ?? [],
                );
            }
        }

        return new SeoCheck();
    }
}
